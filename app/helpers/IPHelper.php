<?php // Nueva clase IPHelper para la mejora 5
class IPHelper
{
    public static function getCountryFromIP($ip)
    {
        try {
            // Añadir un timeout para evitar esperas
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 2
                ]
            ]);

            $response = @file_get_contents("http://ip-api.com/json/{$ip}", false, $ctx);

            if ($response === false) {
                return null;
            }

            $data = json_decode($response);

            if ($data && isset($data->countryCode)) {
                return strtolower($data->countryCode); // Devuelve el código de país en minúsculas
            }

            return null;
        } catch (Exception $e) {
            error_log("Error fetching country for IP {$ip}: " . $e->getMessage());
            return null;
        }
    }

    public static function getFlagUrl($countryCode, $size = "w20")
    {
        if (!$countryCode) return null;
        return "https://flagcdn.com/{$size}/{$countryCode}.png";
    }
}
