<?php
if (!isset($_GET['request'])) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

$config = [
    'proxy-url'    => $_ENV['DVBLINK_DVBPLEX_URL'],
    'dvblink-ip'   => $_ENV['DVBLINK_SERVER'],
    'dvblink-port' => $_ENV['DVBLINK_PORT'],
];

header('Content-Type: application/json');
switch ($_GET['request']) {
    case 'discover.json':
        echo json_encode([
            'FriendlyName'    => 'DVBLink-Proxy',
            'ModelNumber'     => 'HDTC-2US',
            'FirmwareName'    => 'hmhomeruntc_atsc',
            'TunerCount'      => 2,
            'FirmwareVersion' => '20150826',
            'DeviceID'        => '12345678',
            'DeviceAuth'      => 'auth',
            'BaseURL'         => $config['proxy-url'],
            'LineupURL'       => $config['proxy-url'].'/lineup.json',
        ]);
        break;
    case 'lineup_status.json':
        echo json_encode([
            'ScanInProgress' => 0,
            'ScanPossible'   => 1,
            'Source'         => 'Cable',
            'SourceList'     => ['Cable'],
        ]);
        break;
    case 'lineup.json':
        $request = simplexml_load_string(file_get_contents('http://'.$config['dvblink-ip'].':'.$config['dvblink-port'].'/mobile/?command=get_channels'));
        $xml     = simplexml_load_string($request->xml_result);

        $result = [];

        foreach ($xml->channel as $channel) {
            $result[] = [
                'GuideNumber' => sprintf('%d%s', $channel->channel_number, $channel->channel_subnumber > 0 ? '.'.$channel->channel_subnumber : ''),
                'GuideName'   => (string)$channel->channel_name,
                'URL'         => 'http://'.$config['dvblink-ip'].':'.($config['dvblink-port'] + 1).'/dvblink/direct?client=AAABBBCCC&channel='.$channel->channel_dvblink_id,
            ];
        }

        echo json_encode($result);
        break;
}
