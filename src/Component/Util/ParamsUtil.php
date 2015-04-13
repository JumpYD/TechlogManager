<?php

namespace Component\Util;

use Symfony\Component\HttpFoundation\Request;

/**
 * 函数参数辅助函数
 */
class ParamsUtil
{

    /**
     * 检查非空
     *
     * @param array $arrData 需要检查的数据
     * @param array $mustFields 要求非空的字段
     *
     * @throw 非空参数为空时抛出异常
     */
    public static function checkEmpty(&$arrData, $mustFields) {
        foreach ($mustFields as $field) {
            if (empty($arrData[$field])) {
                throw new \Exception("参数($field)不能为空");
            }
        }
    }

    /**
     * 检查参数
     *
     * @param array $arrData 需要检查的数据
     * @param array $mustFields 要求的必须字段
     * @param array $optionFields 可选字段，可以提供默认值
     *
     * @throw 必须参数没有提供时会抛出异常
     */
    public static function checkParams(&$arrData, $mustFields, $optionFields = array()) {
        foreach ($mustFields as $field) {
            self::checkParam($arrData, $field);
        }
        foreach ($optionFields as $field => $default) {
            self::checkParam($arrData, $field, false, $default);
        }
    }

    public static function checkParam(&$arrData, $field, $required = true, $default = null) {
        if ($required && !isset($arrData[$field])) {
            throw new \Exception("缺少参数($field)!");
        }
        if ($default !== null && !isset($arrData[$field])) {
            $arrData[$field] = $default;
        }
    }

    public static function dealQueryParamsForMutiAlias($request, $mutiAliasMap){
        $strMutiWhere = '1=1';
        $arrMutiParams = array();
        foreach($mutiAliasMap as $alias=>$arrFields){
            foreach ($arrFields as $key => $default) {
                $field = self::camelize($key);

                if(is_array($request)){
                    $$field = self::get_kv($request, $key, $default);
                } else {
                    $$field = $request->get($key, $default);
                }

                if ($$field != $default) {
                    $strMutiWhere .= " AND $alias.$field=:${alias}_${field}";
                    $arrMutiParams["${alias}_${field}"] = $$field;
                }
            }
        }
        return array($strMutiWhere, $arrMutiParams);
    }

    /**
     * 统一的，通用处理查询参数
     *
     * @param string
     *
     * @return array，包括两个元素：0=>查询用的where语句；1=>需要设置的参数（预处理方式）
     */
    public static function dealQueryParams($request, $alias, $arrFields, $timeParam='') {
        $strWhere = '1=1';
        $arrParams = array();
        foreach ($arrFields as $key => $default) {
            $field = self::camelize($key);

            if(is_array($request)){
                $$field = self::get_kv($request, $key, $default);
            } else {
                $$field = $request->get($key, $default);
            }

            if ($$field != $default) {
                $strWhere .= empty($alias) ? "AND $field=:$field" : " AND $alias.$field=:$field";
                $arrParams[$field] = $$field;
            }
        }

        $timeField = self::camelize($timeParam);
        $timeMinParam = $timeParam . '_min';
        $timeMaxParam = $timeParam . '_max';
        $timeMinField = self::camelize($timeMinParam);
        $timeMaxField = self::camelize($timeMaxParam);

        if(is_array($request)){
            $$timeMinField = self::get_kv($request, $timeMinParam);
            $$timeMaxField = self::get_kv($request, $timeMaxParam);
        } else {
            $$timeMinField = $request->get($timeMinParam);
            $$timeMaxField = $request->get($timeMaxParam);
        }

        if ($$timeMinField) {
            $strWhere .= empty($alias) ? " AND $timeField>=:$timeMinField" : " AND $alias.$timeField>=:$timeMinField";
            $arrParams[$timeMinField] = $$timeMinField;
        }
        if ($$timeMaxField) {
            $strWhere .= empty($alias) ? " AND $timeField<=:$timeMaxField" : " AND $alias.$timeField<=:$timeMaxField";
            $arrParams[$timeMaxField] = $$timeMaxField;
        }

        return array(
            $strWhere, $arrParams,
        );
    }

    /**
     * 给实体设置字段值，方便 ORM entity 赋值
     *
     * @param $entity ORM 中的实体类实例
     * @param array $arrFields 要给当前entity设置的字段名数组，要求和数据表字段名一致
     * @param array $arrValues 要给字段设置的值，以 $arrFields 中的值为key
     * @param boolean $isInsert 是否为插入操作设置字段值
     *
     * @return 返回实体 $entity
     */
    public static function setEntityFields($entity, array $arrFields, array $arrValues, $isInsert = true) {
        foreach ($arrFields as $field) {
            if (!isset($arrValues[$field]) && !$isInsert) {
                continue;
            }
            $val = (isset($arrValues[$field]) && !is_null($arrValues[$field])) ? $arrValues[$field] : '';
            $setMethod = 'set' . self::camelize($field, 'ucwords');
            $entity->$setMethod($val);
        }

        return $entity;
    }

    /**
     * 拼接where语句
     *
     * @param array $arrFields 字段名数组，要求和数据表字段名一致
     * @param array $arrValues 要给字段设置的值，以 $arrFields 中的值为key
     *
     * @return string $whereStr
     */
    public static function getSqlWhereStr($arrFields, $arrValues, $alias='')
    {
        $where = ' 1=1 ';
        foreach($arrFields as $field){
            if(!isset($arrValues[$field]) || $arrValues[$field] === null){
                continue;
            }
            $key = $alias === '' ? $field : "$alias.$field";
            $val = $arrValues[$field];
            $where .= " and $key = '$val' ";
        }
        return $where;
    }

    public static function camelize($string, $type = 'lcfirst')
    {
        $ucwords = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        switch($type){
            case 'lcfirst':
                return lcfirst($ucwords);
            case 'ucwords':
                return $ucwords;
        }
    }

    public static function get_kv($infos, $key, $default = NULL, $type = NULL)
    {
        $info = isset($infos[$key]) ? $infos[$key] : $default;

        switch($type)
        {
        case 'int':
            $info = (int)$info;
            break;

        case 'float':
            $info = (float)$info;
            break;

		case 'string':
			$info = (string)$info;
			break;

		case 'array':
			$info = (array)$info;
			break;

        case 'bool':
            $info = (bool)$info;
            break;

        default:
            break;
        }

        return $info;
    }
}
