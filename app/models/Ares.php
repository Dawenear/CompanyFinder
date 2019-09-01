<?php


namespace App\Models;

class Ares
{
    const HTTP_COMPANY_BY_NAME = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/ares_es.cgi?obch_jm=';
    const HTTP_COMPANY_BY_ICO = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=';

    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @param $ico
     * @return AresResponse|string
     * @throws \Exception
     */
    public function getCompanyByICO($ico)
    {
        $ico = rawurlencode($ico);
        $data = $this->getDataFromCurl($ico);

        $companyInfo = new AresResponse();
        if ($data) $xml = simplexml_load_string($data);

        if (isset($xml)) {
            $ns = $xml->getDocNamespaces();
            $data = $xml->children($ns['are']);
            $el = $data->children($ns['D'])->VBAS;
            if (strval($el->ICO) == $ico) {

                $companyInfo->setIco(strval($el->ICO));
                $companyInfo->setDic(strval($el->DIC));
                $companyInfo->setName(strval($el->OF));
                $companyInfo->setCity(strval($el->AA->N));
                $companyInfo->setPsc(strval($el->AA->PSC));

                $street = strval($el->AA->NU);
                if (!empty($el->AA->CO) OR !empty($el->AA->CD)) {
                    // detekování popisného a orientačního čísla
                    $street .= " ";
                    if (!empty($el->AA->CD)) $street .= strval($el->AA->CD);
                    if (!empty($el->AA->CO) AND !empty($el->AA->CD)) $street .= "/";
                    if (!empty($el->AA->CO)) $street .= strval($el->AA->CO);
                }
                $companyInfo->setStreet($street);

                $this->database->saveEntryToDB($companyInfo);
                return $companyInfo;
            } else {
                return 'IČO firmy nebylo v databázi ARES nalezeno';
            }
        } else {
            return 'Databáze ARES není dostupná';
        }
    }

    /**
     * @param $name
     * @return AresResponse[]|int|string
     * @throws \Exception
     */
    public function getCompanyByName($name)
    {
        $name = rawurlencode($name);
        var_dump($name);
        $data = $this->getDataFromCurl($name, self::HTTP_COMPANY_BY_NAME);

        if ($data) $xml = simplexml_load_string($data);

        if (isset($xml)) {
            $ns = $xml->getDocNamespaces();
            $data = $xml->children($ns['are']);
            $ela = $data->children($ns['dtt']);
            $el = $ela->children($ns['dtt']);

            if (count($el) === 1) {
                return (int)$el->S->ico;
            } else {
                if (isset($el->R)) {
                    return 'Firma nenalezena';
                }
                $companies = [];
                foreach ($el as $element) {
                    $company = new AresResponse();
                    $company->setIco(strval($element->ico));
                    $company->setName(strval($element->ojm));
                    $company->setCity(strval($element->jmn));
                    $companies[] = $company;
                }
                return $companies;
            }
        }
        return 'Databáze ARES není dostupná';
    }

    private function getDataFromCurl($arg, $url = self::HTTP_COMPANY_BY_ICO)
    {
        $arg = rawurlencode($arg);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.$arg);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }
}