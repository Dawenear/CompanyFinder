<?php

namespace App\Models;

class CompanyFinder
{
    /** @var string */
    private $htmlContent;
    /** @var Ares */
    private $ares;
    /** @var Database */
    private $database;

    public function __construct()
    {
        $this->ares = new Ares();
        $this->database = new Database();
    }

    /**
     * @param $form
     * @return string
     * @throws \Exception
     */
    public function handleForm($form)
    {
        if ($form['ico'] !== '') {
            $response = $this->searchByICO($form['ico']);
        } else {
            $response = $this->ares->getCompanyByName($form['companyName']);
        }

        $this->handleResponse($response);

        return $this->htmlContent;
    }

    /**
     * @param $response
     * @return string
     */
    private function handleResponse($response)
    {
        if (is_string($response)) {
            $this->htmlContent = $response;
        } elseif ($response instanceof AresResponse) {
            $this->htmlContent = $this->printResponse($response);
        } elseif (is_array($response)) {
            $this->createTable($response);
        } else {
            $this->htmlContent = 'Nastala neočekávaná chyba';
        }

        return $this->htmlContent;
    }

    /**
     * @param $ico
     * @return \App\Models\AresResponse|bool|string
     * @throws \Exception
     */
    private function searchByICO($ico)
    {
        if ($data = $this->database->SearchForCompany($ico)) {
            return $data;
        }

        $data = $this->ares->getCompanyByICO($ico);
        $this->database->saveEntryToDB($data);
        return $data;
    }

    /**
     * @param $response AresResponse
     * @return string
     */
    private function printResponse($response)
    {
        return <<<HTML
<table>
    <tr>
        <td>IČO:</td>
        <td>{$response->getIco()}</td>
    </tr>
    <tr>
        <td>DIČ:</td>
        <td>{$response->getDic()}</td>
    </tr>
    <tr>
        <td>Jméno:</td>
        <td>{$response->getName()}</td>
    </tr>
    <tr>
        <td>Město:</td>
        <td>{$response->getCity()}</td>
    </tr>
    <tr>
        <td>Ulice:</td>
        <td>{$response->getStreet()}</td>
    </tr>
    <tr>
        <td>PSČ:</td>
        <td>{$response->getPsc()}</td>
    </tr>
</table>
HTML;

    }

    /**
     * @param AresResponse[] $response
     */
    private function createTable(array $response)
    {
        $html = <<<HTML
<table id="sortable">
    <thead>
    <tr>
        <th onclick="sortTable(0)">
            IČO
        </th>
        <th onclick="sortTable(1)">
            Jméno
        </th>
        <th onclick="sortTable(2)">
            Sídlo
        </th>
    </tr>
    </thead>
    <tbody>
HTML;

        foreach ($response as $company) {
            $html .= <<<HTML
<tr>
    <td>
        <form method="post">
            <input type="hidden" name="ico" value="{$company->getIco()}">
            <button name="searchCompany" class="buttonLink">
                {$company->getIco()}
            </button>
        </form>
    </td>
    <td>
        {$company->getName()}
    </td>
    <td>
        {$company->getCity()}
    </td>
</tr>
HTML;

        }
        $html .= '</tbody></table>';
        $this->htmlContent = $html;
    }
}