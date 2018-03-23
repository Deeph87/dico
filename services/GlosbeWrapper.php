<?php
/**
 * Created by PhpStorm.
 * User: jhaudry
 * Date: 22/03/2018
 * Time: 01:18
 */

namespace Dico\Services;


class GlosbeWrapper
{
    public static function getWordDefinitions($word, $from = 'fra', $dest = 'eng')
    {
        $ret = [];
        if (!empty($word)) {
            $word = urlencode(strtolower($word));
            $url = 'https://glosbe.com/gapi/translate?from=' . $from . '&dest=' . $dest . '&format=json&pretty=false&phrase=' . htmlspecialchars($word);
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
            ]);
            $resp = curl_exec($curl);
            curl_close($curl);

            $resp = json_decode($resp, true);

            $ret = ['word' => $word];
            if (!empty($resp['tuc'])) {
                foreach ($resp['tuc'] as $infos) {
                    if (!empty($infos['meanings'])) {
                        foreach ($infos['meanings'] as $meaning) {
                            if (!empty($meaning['language']) && $meaning['language'] == 'fr') {
                                $ret['meanings'][] = $meaning;
                            }
                        }
                    }

                }
            }
        }
        return $ret;
    }
}