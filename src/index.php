<?php

class TCKimlikDogrula
{

    private function check_SoapClient($data)
    {
        $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
        try {
            $result = $client->TCKimlikNoDogrula($data);
            if ($result->TCKimlikNoDogrulaResult) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->faultstring;
        }
    }

    private function check_Normal($data)
    {
        $SoapData = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
        <TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
        <TCKimlikNo>' . $data["TCKimlikNo"] . '</TCKimlikNo>
        <Ad>' . $data["Ad"] . '</Ad>
        <Soyad>' . $data["Soyad"] . '</Soyad>
        <DogumYili>' . $data["DogumYili"] . '</DogumYili>
        </TCKimlikNoDogrula>
        </soap:Body>
        </soap:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST,           true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,    $SoapData);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
            'POST /Service/KPSPublic.asmx HTTP/1.1',
            'Host: tckimlik.nvi.gov.tr',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
            'Content-Length: ' . strlen($SoapData)
        ));
        
        $returnData = curl_exec($ch);
        curl_close($ch);
        if(strip_tags($returnData) == "true")
            return true;
        return false;
    }

    function check($kimlik, $ad, $soyad, $dogumyili)
    {
        $data = [
            'TCKimlikNo' => $kimlik,
            'Ad' => $ad,
            'Soyad' => $soyad,
            'DogumYili' => $dogumyili
        ];

        if (extension_loaded('soap')) {
            $check = $this->check_SoapClient($data);
        } else {
            $check = $this->check_Normal($data);
        }

        return $check;
    }
}
