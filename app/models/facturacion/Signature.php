<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 24/04/2021
 * Time: 11:01 a. m.
 */
require 'libs/ApiFacturacion/api_signature/XMLSecurityKey.php';
require 'libs/ApiFacturacion/api_signature/XMLSecurityDSig.php';
require 'libs/ApiFacturacion/api_signature/XMLSecEnc.php';

class Signature
{
    public function signature_xml_normal($flg_firma, $ruta, $ruta_firma, $pass_firma) {
        $doc = new DOMDocument();

        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->load($ruta);

        $objDSig = new XMLSecurityDSig(FALSE);
        $objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);
        $options['force_uri'] = TRUE;
        $options['id_name'] = 'ID';
        $options['overwrite'] = FALSE;

        $objDSig->addReference($doc, XMLSecurityDSig::SHA1, array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'), $options);
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));

        $pfx = file_get_contents($ruta_firma);
        $key = array();

        if (!$pfx) {
            throw new Exception("No se pudo leer el archivo de firma en la ruta: $ruta_firma");
        }

        if (!openssl_pkcs12_read($pfx, $key, $pass_firma)) {
            throw new Exception("Error al leer el archivo PFX. Verifica la contraseña y el archivo.");
        }

        if (!isset($key["pkey"]) || !isset($key["cert"])) {
            throw new Exception("Archivo PFX no contiene 'pkey' o 'cert'.");
        }
        $objKey->loadKey($key["pkey"]);
        $objDSig->add509Cert($key["cert"], TRUE, FALSE);
        $objDSig->sign($objKey, $doc->documentElement->getElementsByTagName("ExtensionContent")->item($flg_firma));

        $atributo = $doc->getElementsByTagName('Signature')->item(0);
        $atributo->setAttribute('Id', 'SignatureSP');

        //===================rescatamos Codigo(HASH_CPE)==================
        $hash_cpe = $doc->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        $firma_cpe = $doc->getElementsByTagName('SignatureValue')->item(0)->nodeValue;

        $doc->save($ruta);
        $resp['respuesta'] = 'ok';
        $resp['hash_cpe'] = $hash_cpe;
        $resp['firma_cpe'] = $firma_cpe;
        return $resp;
    }

    public function signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma, $ruta_key = "libs/ApiFacturacion/key_20162270134.pem", $ruta_cert = "libs/ApiFacturacion/cert_20162270134.pem") {
        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->load($ruta);

        $objDSig = new XMLSecurityDSig(FALSE);
        $objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);

        $options = [
            'force_uri' => TRUE,
            'id_name' => 'ID',
            'overwrite' => FALSE,
        ];

        $objDSig->addReference(
            $doc,
            XMLSecurityDSig::SHA1,
            ['http://www.w3.org/2000/09/xmldsig#enveloped-signature'],
            $options
        );

        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, ['type'=>'private']);
        $objKey->loadKey($ruta_key, TRUE); // TRUE = es archivo

        $cert = file_get_contents($ruta_cert);
        $objDSig->add509Cert($cert, TRUE, FALSE);

        $targetNode = $doc->getElementsByTagName("ExtensionContent")->item($flg_firma);
        $objDSig->sign($objKey, $targetNode);

        $atributo = $doc->getElementsByTagName('Signature')->item(0);
        $atributo->setAttribute('Id', 'SignatureSP');

        $hash_cpe = $doc->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        $firma_cpe = $doc->getElementsByTagName('SignatureValue')->item(0)->nodeValue;

        $doc->save($ruta);

        return [
            'respuesta' => 'ok',
            'hash_cpe' => $hash_cpe,
            'firma_cpe' => $firma_cpe
        ];
    }
}