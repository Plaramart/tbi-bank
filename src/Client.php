<?php

namespace Plaramart\TbiBank;

use Plaramart\TbiBank\Interfaces\TBIRequestContract;

class Client
{

    private string $apiKey;
    private string $pathToCertificate;

    public function __construct (string $apiKey, string $pathToCertificate)
    {

        $this->apiKey = $apiKey;
        $this->pathToCertificate = $pathToCertificate;
    }


    public function execute (TBIRequestContract $endpoint)
    {
        $data = [
            'name'  => $endpoint->getAction(),
            'param' => $endpoint->getRequestDataFormatted(),
        ];

        $data['param']['unicid'] = $this->apiKey;

        $encryptedData = $this->encrypt($data);

        $tbi_ch = curl_init();
        curl_setopt_array($tbi_ch, [
            CURLOPT_URL            => "https://tbibank.support/api/index.php",
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 2,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode(['data' => $encryptedData]),
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "cache-control: no-cache",
            ],
        ]);
        $responseapi = curl_exec($tbi_ch);
        $err = curl_error($tbi_ch);
        curl_close($tbi_ch);


        /** Извличане на резултата от изпълнението на функцията */
        $api_obj = json_decode($responseapi, TRUE);

        return $api_obj['data']['result'] ?? '';
    }

    protected function encrypt (array $data)
    {
        $tbi_plaintext = json_encode($data);
        /** Път до файла със сертификата който сте получили */
        $tbi_publicKey = openssl_pkey_get_public(file_get_contents($this->pathToCertificate));
        $tbi_a_key = openssl_pkey_get_details($tbi_publicKey);
        $tbi_chunkSize = ceil($tbi_a_key['bits'] / 8) - 11;
        $tbi_output = '';
        while ($tbi_plaintext) {
            $tbi_chunk = substr($tbi_plaintext, 0, $tbi_chunkSize);
            $tbi_plaintext = substr($tbi_plaintext, $tbi_chunkSize);
            $tbi_encrypted = '';
            if (!openssl_public_encrypt($tbi_chunk, $tbi_encrypted, $tbi_publicKey)) {
                die('Failed to encrypt data');
            }
            $tbi_output .= $tbi_encrypted;
        }
        openssl_free_key($tbi_publicKey);

        return base64_encode($tbi_output);
    }
}