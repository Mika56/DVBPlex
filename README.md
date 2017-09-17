# DVBPlex
Simple container using Apache and PHP that allows the use of a DVBLink server in Plex.

This container translates the HDHomeRun API to DVBLink, allowing you to use the latter to record and watch live TV in Plex.

## Usage
Three environment variables must be defined for this to work:
* _DVBLINK_DVBPLEX_URL_ : The url Plex can use to communicate with the container, e.g. `http://dvbplex.home.local:5004/` or `http://192.168.1.249:5004/`
* _DVBLINK_SERVER_ : The DVBLink server, without port, e.g. `192.168.1.248` or `dvblink.home.local`
* _DVBLINK_PORT_ : The DVBLink server port, e.g. `8080`

The container exposes the port 80, but you should map it to port 5004 to ensure a better detection by Plex.

To run under Docker, use:
```shell
docker run -p 5004:80 -e DVBLINK_DVBPLEX_URL=http://dvbplex.home.local:5004 -e DVBLINK_SERVER=192.168.1.248 -e DVBLINK_PORT=8080 mika56/dvbplex:latest
```
