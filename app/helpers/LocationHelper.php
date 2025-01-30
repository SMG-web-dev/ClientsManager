<?php // Nueva clase LocationHelper para la mejora 10
class LocationHelper
{
    public static function getLocationFromIP($ip)
    {
        try {
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 2
                ]
            ]);

            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,lat,lon,country,city", false, $ctx);

            if ($response === false) {
                return null;
            }

            $data = json_decode($response);

            if ($data && $data->status === 'success') {
                return [
                    'lat' => $data->lat,
                    'lon' => $data->lon,
                    'country' => $data->country,
                    'city' => $data->city
                ];
            }

            return null;
        } catch (Exception $e) {
            error_log("Error fetching location for IP {$ip}: " . $e->getMessage());
            return null;
        }
    }
}
