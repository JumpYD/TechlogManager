<?php
namespace Component\Util;

class Security {

    public function CliEncryptData($data)
    {
        return npp_c_pack($this->npp_c_packer_, $data);
    }

    public function CliDecryptData($data)
    {
        return npp_c_unpack($this->npp_c_packer_, $data);
    }

    public function SrvEncryptData($data)
    {
        return npp_s_pack($this->npp_s_unpacker_, $data);
    }

    public function SrvDecryptData($data)
    {
        return npp_s_unpack($this->npp_s_unpacker_, $data);
    }

    public function __construct($business, $symmetric_key_file="symmetric_keys.bin", $server_asym_keyfile="sasymmetric_keys.bin", $client_asym_keyfile="casymmetric_keys.bin")
    {/*{{{*/
        if(!extension_loaded('netproto_srv')) {
                die("Error: Please install netproto_srv extension!\n");
        }
        $this->npp_s_handler_ = npp_get_handler($symmetric_key_file, $business . "_server", $server_asym_keyfile);
        $this->npp_s_unpacker_ = npp_create_s_unpacker($this->npp_s_handler_);

        $this->npp_c_handler_ = npp_get_handler($symmetric_key_file, $business . "_client", $client_asym_keyfile);
        $this->npp_c_packer_ = npp_create_c_packer($this->npp_c_handler_, 6);
        npp_c_packer_set_option($this->npp_c_packer_, "compress_method", 1);
        npp_c_packer_set_option($this->npp_c_packer_, "asymmetric_method", 0);
        npp_c_packer_set_option($this->npp_c_packer_, "symmetric_method", 0);
    }/*}}}*/

    private $npp_c_packer_;

    private $npp_s_unpacker_;

    private $npp_c_handler_;
    private $npp_s_handler_;
};
