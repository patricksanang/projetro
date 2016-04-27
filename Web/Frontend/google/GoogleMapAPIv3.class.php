<?php

/* * *************************************************************
 * Copyright notice
 *
 * (c) 2013 Yohann CERDAN <cerdanyohann@yahoo.fr>
 * All rights reserved
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Class to use the Google Maps v3 API
 *
 * @author Yohann CERDAN <cerdanyohann@yahoo.fr>
 */
class GoogleMapAPI {

    /** GoogleMap ID for the HTML DIV and identifier for all the methods (to have several gmaps) * */
    protected $googleMapId = 'googlemapapi';

    /** GoogleMap  Direction ID for the HTML DIV * */
    protected $googleMapDirectionId = 'route';

    /** Width of the gmap * */
    protected $width = '';

    /** Height of the gmap * */
    protected $height = '';

    /** Icon width of the gmarker * */
    protected $iconWidth = 20;

    /** Icon height of the gmarker * */
    protected $iconHeight = 34;

    /** Icon width of the gmarker * */
    protected $iconAnchorWidth = 0;

    /** Icon height of the gmarker * */
    protected $iconAnchorHeight = 0;

    /** Infowindow width of the gmarker * */
    protected $infoWindowWidth = 250;

    /** Default zoom of the gmap * */
    protected $zoom = 9;

    /** Enable the zoom of the Infowindow * */
    protected $enableWindowZoom = FALSE;

    /** Default zoom of the Infowindow * */
    protected $infoWindowZoom = 6;

    /** Lang of the gmap * */
    protected $lang = 'fr';

    /*     * Center of the gmap * */
    protected $center = 'Paris France';

    /** Content of the HTML generated * */
    protected $content = '';

    /** Add the direction button to the infowindow * */
    protected $displayDirectionFields = FALSE;

    /** Hide the marker by default * */
    protected $defaultHideMarker = FALSE;

    /** Extra content (marker, etc...) * */
    protected $contentMarker = '';

    /** Use clusterer to display a lot of markers on the gmap * */
    protected $useClusterer = FALSE;
    protected $gridSize = 100;
    protected $maxZoom = 9;
    protected $clustererLibrarypath = 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0/src/markerclusterer_packed.js';

    /** Enable automatic center/zoom * */
    protected $enableAutomaticCenterZoom = FALSE;

    /** maximum longitude of all markers * */
    protected $maxLng = -1000000;

    /** minimum longitude of all markers * */
    protected $minLng = 1000000;

    /** max latitude of all markers * */
    protected $maxLat = -1000000;

    /** min latitude of all markers * */
    protected $minLat = 1000000;

    /** map center latitude (horizontal), calculated automatically as markers are added to the map * */
    protected $centerLat = NULL;

    /** map center longitude (vertical),  calculated automatically as markers are added to the map * */
    protected $centerLng = NULL;

    /** factor by which to fudge the boundaries so that when we zoom encompass, the markers aren't too close to the edge * */
    protected $coordCoef = 0.01;

    /** Type of map to display * */
    protected $mapType = 'ROADMAP';

    /** Include the JS or not (if you have multiple maps * */
    protected $includeJs = TRUE;

    /** Enable geolocation and center map * */
    protected $enableGeolocation = FALSE;

    /**
     * list of added polylines
     *
     * @var array
     */
    protected $_polylines = array();

    /**
     * Class constructor
     */
    public function __construct() {
        
    }

    /**
     * Set the useClusterer parameter (optimization to display a lot of marker)
     *
     * @param boolean $useClusterer         use cluster or not
     * @param int     $gridSize             grid size (The grid size of a cluster in pixel.Each cluster will be a square.If you want the algorithm to run faster, you can set this value larger.The default value is 100.)
     * @param int     $maxZoom              maxZoom (The max zoom level monitored by a marker cluster.If not given, the marker cluster assumes the maximum map zoom level.When maxZoom is reached or exceeded all markers will be shown without cluster.)
     * @param string  $clustererLibraryPath clustererLibraryPath
     *
     * @return void
     */
    public function setClusterer($useClusterer, $gridSize = 100, $maxZoom = 9, $clustererLibraryPath = '') {
        $this->useClusterer = $useClusterer;
        $this->gridSize = $gridSize;
        $this->maxZoom = $maxZoom;
        ($clustererLibraryPath == '') ? $this->clustererLibraryPath = 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0/src/markerclusterer_packed.js' : $this->clustererLibraryPath = $clustererLibraryPath;
    }

    /**
     * Set the type of map, can be :
     * HYBRID, TERRAIN, ROADMAP, SATELLITE
     *
     * @param string $type
     * @return void
     */
    public function setMapType($type) {
        $mapsType = array('ROADMAP', 'HYBRID', 'TERRAIN', 'SATELLITE');
        if (!in_array(strtoupper($type), $mapsType)) {
            $this->mapType = $mapsType[0];
        } else {
            $this->mapType = strtoupper($type);
        }
    }

    /**
     * Set the ID of the default gmap DIV
     *
     * @param string $googleMapId the google div ID
     *
     * @return void
     */
    public function setDivId($googleMapId) {
        $this->googleMapId = $googleMapId;
    }

    /**
     * Set the ID of the default gmap direction DIV
     *
     * @param string $googleMapDirectionId GoogleMap  Direction ID for the HTML DIV
     *
     * @return void
     */
    public function setDirectionDivId($googleMapDirectionId) {
        $this->googleMapDirectionId = $googleMapDirectionId;
    }

    /**
     * Set the size of the gmap
     *
     * @param int $width  GoogleMap  width
     * @param int $height GoogleMap  height
     *
     * @return void
     */
    public function setSize($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getEnableGeolocation() {
        return $this->enableGeolocation;
    }

    /**
     * @param mixed $enableGeolocation
     */
    public function setEnableGeolocation($enableGeolocation) {
        $this->enableGeolocation = $enableGeolocation;
    }

    /**
     * Set the with of the gmap infowindow (on marker clik)
     *
     * @param int $infoWindowWidth GoogleMap  info window width
     *
     * @return void
     */
    public function setInfoWindowWidth($infoWindowWidth) {
        $this->infoWindowWidth = $infoWindowWidth;
    }

    /**
     * Set the size of the icon markers
     *
     * @param int $iconWidth  GoogleMap  marker icon width
     * @param int $iconHeight GoogleMap  marker icon height
     *
     * @return void
     */
    public function setIconSize($iconWidth, $iconHeight) {
        $this->iconWidth = $iconWidth;
        $this->iconHeight = $iconHeight;
    }

    /**
     * Set the size of anchor icon markers
     *
     * @param int $iconAnchorWidth  GoogleMap  anchor icon width
     * @param int $iconAnchorHeight GoogleMap  anchor icon height
     *
     * @return void
     */
    public function setIconAnchorSize($iconAnchorWidth, $iconAnchorHeight) {
        $this->iconAnchorWidth = $iconAnchorWidth;
        $this->iconAnchorHeight = $iconAnchorHeight;
    }

    /**
     * Set the lang of the gmap
     *
     * @param string $lang GoogleMap  lang : fr,en,..
     *
     * @return void
     */
    public function setLang($lang) {
        $this->lang = $lang;
    }

    /**
     * Set the zoom of the gmap
     *
     * @param int $zoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setZoom($zoom) {
        $this->zoom = $zoom;
    }

    /**
     * Set the zoom of the infowindow
     *
     * @param int $infoWindowZoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setInfoWindowZoom($infoWindowZoom) {
        $this->infoWindowZoom = $infoWindowZoom;
    }

    /**
     * Enable the zoom on the marker when you click on it
     *
     * @param int $enableWindowZoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setEnableWindowZoom($enableWindowZoom) {
        $this->enableWindowZoom = $enableWindowZoom;
    }

    /**
     * Enable theautomatic center/zoom at the gmap load
     *
     * @param int $enableAutomaticCenterZoom GoogleMap  zoom.
     *
     * @return void
     */
    public function setEnableAutomaticCenterZoom($enableAutomaticCenterZoom) {
        $this->enableAutomaticCenterZoom = $enableAutomaticCenterZoom;
    }

    /**
     * Set the center of the gmap (an address)
     *
     * @param string $center GoogleMap  center (an address)
     *
     * @return void
     */
    public function setCenter($center) {
        $this->center = $center;
    }

    /**
     * Set the center of the gmap (a lat and lng)
     *
     * @param string $lat
     * @param string $lng
     *
     * @return void
     */
    public function setCenterLatLng($lat, $lng) {
        $this->centerLatLng = 'new google.maps.LatLng(' . $lat . ', ' . $lng . ')';
    }

    /**
     * Set the center of the gmap
     *
     * @param boolean $displayDirectionFields display directions or not in the info window
     *
     * @return void
     */
    public function setDisplayDirectionFields($displayDirectionFields) {
        $this->displayDirectionFields = $displayDirectionFields;
    }

    /**
     * Set the defaultHideMarker
     *
     * @param boolean $defaultHideMarker hide all the markers on the map by default
     *
     * @return void
     */
    public function setDefaultHideMarker($defaultHideMarker) {
        $this->defaultHideMarker = $defaultHideMarker;
    }

    /**
     * Set the includeJs
     *
     * @param boolean $includeJs do not include JS
     *
     * @return void
     */
    public function setincludeJs($includeJs) {
        $this->includeJs = $includeJs;
    }

    /**
     * Get the google map content
     *
     * @return string the google map html code
     */
    public function getGoogleMap() {
        return $this->content;
    }

    /**
     * Get URL content using cURL.
     *
     * @param string $url the url
     *
     * @return string the html code
     *
     * @todo add proxy settings
     */
    public function getContent($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

    /**
     * Geocoding an address (address -> lat,lng)
     *
     * @param string $address an address
     *
     * @return array array with precision, lat & lng
     */
    public function geocoding($address) {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true';

        if (function_exists('curl_init')) {
            $data = $this->getContent($url);
        } else {
            $data = file_get_contents($url);
        }

        $response = json_decode($data, TRUE);
        $status = $response['status'];

        if ($status == 'OK') {
            $return = array(
                $status,
                $response['results'][0]['types'],
                $response['results'][0]['geometry']['location']['lat'],
                $response['results'][0]['geometry']['location']['lng']
            ); // successful geocode, $status-$precision-$lat-$lng
        } else {
            echo '<!-- geocoding : failure to geocode : ' . $status . " -->\n";
            $return = NULL; // failure to geocode
        }

        return $return;
    }

    /**
     * Add marker by his coord
     *
     * @param string $lat      lat
     * @param string $lng      lngs
     * @param string $title    title
     * @param string $html     html code display in the info window
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addMarkerByCoords($lat, $lng, $title, $html = '', $category = '', $icon = '', $id = '') {
        if ($icon == '') {
            $icon = 'http://maps.gstatic.com/mapfiles/markers2/marker.png';
        }

        // Save the lat/lon to enable the automatic center/zoom
        $this->maxLng = (float) max((float) $lng, $this->maxLng);
        $this->minLng = (float) min((float) $lng, $this->minLng);
        $this->maxLat = (float) max((float) $lat, $this->maxLat);
        $this->minLat = (float) min((float) $lat, $this->minLat);
        $this->centerLng = (float) ($this->minLng + $this->maxLng) / 2;
        $this->centerLat = (float) ($this->minLat + $this->maxLat) / 2;

        $this->contentMarker .= "\t" . 'addMarker(new google.maps.LatLng("' . $lat . '","' . $lng . '"),"' . $title . '","' . $html . '","' . $category . '","' . $icon . '",map' . $this->googleMapId . ',"' . $id . '");' . "\n";
    }

    /**
     * Add marker by his address
     *
     * @param string $address  an ddress
     * @param string $title    title
     * @param string $content  html code display in the info window
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addMarkerByAddress($address, $title = '', $content = '', $category = '', $icon = '', $id = '') {
        $point = $this->geocoding($address);
        if ($point !== NULL) {
            $this->addMarkerByCoords($point[2], $point[3], $title, $content, $category, $icon, $id);
        } else {
            echo '<!-- addMarkerByAddress : ADDRESS NOT FOUND ' . strip_tags($address) . " -->\n";
        }
    }

    /**
     * Add marker by an array of coord
     *
     * @param string $coordtab an array of lat,lng,content
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addArrayMarkerByCoords($coordtab, $category = '', $icon = '') {
        foreach ($coordtab as $coord) {
            $this->addMarkerByCoords($coord[0], $coord[1], $coord[2], $coord[3], $category, $icon, (!empty($coord[4])) ? $coord[4] : '');
        }
    }

    /**
     * Add marker by an array of address
     *
     * @param string $coordtab an array of address
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addArrayMarkerByAddress($coordtab, $category = '', $icon = '') {
        foreach ($coordtab as $coord) {
            $this->addMarkerByAddress($coord[0], $coord[1], $coord[2], $category, $icon, (!empty($coord[3])) ? $coord[3] : '');
        }
    }

    /**
     * Set a direction between 2 addresss and set a text panel
     *
     * @param string $from an address
     * @param string $to   an address
     *
     * @return void
     */
    public function addDirection($fromLat, $fromLon, $toLat, $toLon) {
        $this->contentMarker .= 'addDirection("' . $fromLat . '","' . $fromLon . '","' . $toLat . '","' . $toLon . '");';
    }

	public function addDirectionPoints($fromLat, $fromLon, $toLat, $toLon, $points){
		//var_dump($points);
		$chaine='';
		
		foreach($points as $p)
		{
			$chaine.=$p[0].';'.$p[1].':';
		}
		
		//echo $chaine;
		// JS public function to set direction
		//drawRoutePointsAndWaypoints
        $this->contentMarker .= 'drawRoutePointsAndWaypoints("' . $chaine . '");';
	}
    /**
     * Parse a KML file and add markers to a category
     *
     * @param string $url      url of the kml file compatible with gmap and gearth
     * @param string $category marker category
     * @param string $icon     an icon url
     *
     * @return void
     */
    public function addKML($url, $category = '', $icon = '') {
        $xml = new SimpleXMLElement($url, NULL, TRUE);
        foreach ($xml->Document->Folder->Placemark as $item) {
            $coordinates = explode(',', (string) $item->Point->coordinates);
            $name = (string) $item->name;
            $this->addMarkerByCoords($coordinates[1], $coordinates[0], $name, $name, $category, $icon);
        }
    }

    /**
     * Initialize the javascript code
     *
     * @return void
     */
    public function init() {
        // Google map DIV
        if (($this->width != '') && ($this->height != '')) {
            $this->content .= "\t" . '<div id="' . $this->googleMapId . '" style="width:' . $this->width . ';height:' . $this->height . '"></div>' . "\n";
        } else {
            $this->content .= "\t" . '<div id="' . $this->googleMapId . '"></div>' . "\n";
        }

        if ($this->includeJs === TRUE) {
            // Google map JS
            $this->content .= '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=' . $this->lang . '">';
            $this->content .= '</script>' . "\n";

            // Clusterer JS
            if ($this->useClusterer == TRUE) {
                $this->content .= '<script src="' . $this->clustererLibraryPath . '" type="text/javascript"></script>' . "\n";
            }
        }

        $this->content .= '<script type="text/javascript">' . "\n";


        $this->content .= 'function addLoadEvent(func) { ' . "\n";
        $this->content .= 'var oldonload = window.onload; ' . "\n";
        $this->content .= 'if (typeof window.onload != \'function\') { ' . "\n";
        $this->content .= 'window.onload = func; ' . "\n";
        $this->content .= '} else { ' . "\n";
        $this->content .= 'window.onload = function() { ' . "\n";
        $this->content .= 'if (oldonload) { ' . "\n";
        $this->content .= ' oldonload(); ' . "\n";
        $this->content .= '} ' . "\n";
        $this->content .= ' func(); ' . "\n";
        $this->content .= '} ' . "\n";
        $this->content .= '}' . "\n";
        $this->content .= '} ' . "\n";

        //global variables
        $this->content .= 'var geocoder = new google.maps.Geocoder();' . "\n";
        $this->content .= 'var map' . $this->googleMapId . ';' . "\n";
        $this->content .= 'var gmarkers = [];' . "\n";
        $this->content .= 'var infowindow;' . "\n";
        $this->content .= 'var directions = new google.maps.DirectionsRenderer();' . "\n";
        $this->content .= 'var directionsService = new google.maps.DirectionsService();' . "\n";
        $this->content .= 'var current_lat = 0;' . "\n";
        $this->content .= 'var current_lng = 0;' . "\n";

        // JS public function to get current Lat & Lng
        $this->content .= "\t" . 'function getCurrentLat() {' . "\n";
        $this->content .= "\t\t" . 'return current_lat;' . "\n";
        $this->content .= "\t" . '}' . "\n";
        $this->content .= "\t" . 'function getCurrentLng() {' . "\n";
        $this->content .= "\t\t" . 'return current_lng;' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to add a  marker
        $this->content .= "\t" . 'function addMarker(latlng,title,content,category,icon,currentmap,id) {' . "\n";
        $this->content .= "\t\t" . 'var marker = new google.maps.Marker({' . "\n";
        $this->content .= "\t\t\t" . 'map:  currentmap,' . "\n";
        $this->content .= "\t\t\t" . 'title : title,' . "\n";
        $this->content .= "\t\t\t" . 'icon:  {url:icon,size:new google.maps.Size(' . $this->iconWidth . ', ' . $this->iconHeight . ')';
        if (!empty($this->iconAnchorWidth) || !empty($this->iconAnchorHeight)) {
            $this->content .= ',anchor:new google.maps.Point(' . $this->iconAnchorWidth . ',' . $this->iconAnchorHeight . ')';
        }
        $this->content .= '},' . "\n";
        $this->content .= "\t\t\t" . 'position: latlng' . "\n";
        $this->content .= "\t\t" . '});' . "\n";

        // Display direction inputs in the info window
        if ($this->displayDirectionFields == TRUE) {
            $this->content .= "\t\t" . 'content += \'<div style="clear:both;height:20px;"></div>\';' . "\n";
            $this->content .= "\t\t" . 'id_name = \'marker_\'+gmarkers.length;' . "\n";
            $this->content .= "\t\t" . 'content += \'<input type="text" id="\'+id_name+\'"/>\';' . "\n";
            $this->content .= "\t\t" . 'var from = ""+latlng.lat()+","+latlng.lng();' . "\n";
            $this->content .= "\t\t" . 'content += \'<br /><input type="button" onClick="addDirection(to.value,document.getElementById(\\\'\'+id_name+\'\\\').value);" value="Arriv�e"/>\';' . "\n";
            $this->content .= "\t\t" . 'content += \'<input type="button" onClick="addDirection(document.getElementById(\\\'\'+id_name+\'\\\').value,to.value);" value="D�part"/>\';' . "\n";
        }

        $this->content .= "\t\t" . 'var html = \'<div style="text-align:left;width:' . $this->infoWindowWidth . 'px;" class="infoGmaps">\'+content+\'</div>\';' . "\n";
        $this->content .= "\t\t" . 'google.maps.event.addListener(marker, "click", function() {' . "\n";
        $this->content .= "\t\t\t" . 'if (infowindow) infowindow.close();' . "\n";
        $this->content .= "\t\t\t" . 'infowindow = new google.maps.InfoWindow({content: html,disableAutoPan: false});' . "\n";
        $this->content .= "\t\t\t" . 'infowindow.open(currentmap,marker);' . "\n";

        // Enable the zoom when you click on a marker
        if ($this->enableWindowZoom == TRUE) {
            $this->content .= "\t\t\t" . 'currentmap.setCenter(new google.maps.LatLng(latlng.lat(),latlng.lng()),' . $this->infoWindowZoom . ');' . "\n";
        }

        $this->content .= "\t\t" . '});' . "\n";
        $this->content .= "\t\t" . 'marker.mycategory = category;' . "\n";
        $this->content .= "\t\t" . 'if (id) marker.id = id; else marker.id = \'marker_\'+gmarkers.length;' . "\n";
        $this->content .= "\t\t" . 'gmarkers.push(marker);' . "\n";

        // Hide marker by default
        if ($this->defaultHideMarker == TRUE) {
            $this->content .= "\t\t" . 'marker.setVisible(false);' . "\n";
        }
        $this->content .= "\t" . '}' . "\n";

        // JS public function to add a geocode marker
        $this->content .= "\t" . 'function geocodeMarker(address,title,content,category,icon) {' . "\n";
        $this->content .= "\t\t" . 'if (geocoder) {' . "\n";
        $this->content .= "\t\t\t" . 'geocoder.geocode( { "address" : address}, function(results, status) {' . "\n";
        $this->content .= "\t\t\t\t" . 'if (status == google.maps.GeocoderStatus.OK) {' . "\n";
        $this->content .= "\t\t\t\t\t" . 'var latlng = 	results[0].geometry.location;' . "\n";
        $this->content .= "\t\t\t\t\t" . 'addMarker(results[0].geometry.location,title,content,category,icon)' . "\n";
        $this->content .= "\t\t\t\t" . '}' . "\n";
        $this->content .= "\t\t\t" . '});' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to center the gmaps dynamically
        $this->content .= "\t" . 'function geocodeCenter(address) {' . "\n";
        $this->content .= "\t\t" . 'if (geocoder) {' . "\n";
        $this->content .= "\t\t\t" . 'geocoder.geocode( { "address": address}, function(results, status) {' . "\n";
        $this->content .= "\t\t\t\t" . 'if (status == google.maps.GeocoderStatus.OK) {' . "\n";
        $this->content .= "\t\t\t\t" . 'map' . $this->googleMapId . '.setCenter(results[0].geometry.location);' . "\n";
        $this->content .= "\t\t\t\t" . '} else {' . "\n";
        $this->content .= "\t\t\t\t" . 'alert("Geocode was not successful for the following reason: " + status);' . "\n";
        $this->content .= "\t\t\t\t" . '}' . "\n";
        $this->content .= "\t\t\t" . '});' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t" . '}' . "\n";

      /*  // JS public function to set multiple direction
        $this->content .= "\t" . 'function drawRoutePointsAndWaypoints(Points) {'. "\n";
        "\t\t". 'var _waypoints = new Array();'. "\n";
        "\t\t". 'if (Points . length > 2) {'. "\n";
        "\t\t". 'for (var j = 1;j < Points . length - 1; j++) {'. "\n";
        "\t\t". 'var address = Points[j];'. "\n";
        "\t\t". 'if (address !== "") {'. "\n";
        "\t\t\t". '_waypoints.push( {'. "\n";
        "\t\t\t". 'location: address,'. "\n";
        "\t\t\t". 'stopover: true'. "\n";
        "\t\t\t". '});'. "\n";
        "\t\t". '}'. "\n";
        "\t". '}'. "\n";
            addDirection(Points[0], Points[Points . length - 1], _waypoints);
        } else if (Points . length > 1) {
            //Call a drawRoute() function only for start and end locations
            drawRoute(Points[_mapPoints . length - 2], Points[Points . length - 1], _waypoints);
        } else {
            //Call a drawRoute() function only for one point as start and end locations.
            drawRoute(Points[_mapPoints . length - 1], Points[Points . length - 1], _waypoints);
        }
        }
*/
        // JS public function to set direction
        $this->content .= "\t" . 'function addDirection(fromLat, fromLon,toLat, toLon) {' . "\n";
        $this->content .= "\t\t" . 'var from = new google.maps.LatLng(fromLat, fromLon);' . "\n";
        $this->content .= "\t\t" . 'var to = new google.maps.LatLng(toLat, toLon);' . "\n";
        //$this->content .= "alert(from); alert(to);" . "\n";
        $this->content .= "\t\t" . 'var request = {' . "\n";
        $this->content .= "\t\t" . 'origin:from, ' . "\n";
        $this->content .= "\t\t" . 'destination:to,' . "\n";
        $this->content .= "\t\t" . 'travelMode: google.maps.DirectionsTravelMode.DRIVING' . "\n";
        $this->content .= "\t\t" . '};' . "\n";
        $this->content .= "" . "\n";
        $this->content .= "\t\t" . 'directionsService.route(request, function(response, status) {' . "\n";
        $this->content .= "\t\t" . 'if (status == google.maps.DirectionsStatus.OK) {' . "\n";
        $this->content .= "\t\t" . 'directions.setDirections(response);' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . '});' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

		$this->content .= "\t\t" . 'function drawRoutePointsAndWaypoints(chaine) {'."\n";
		$this->content .= "\t\t" . 'var tab=new Array();'."\n";
		$this->content .= "\t\t" . 'var tableau=chaine.split(":");'."\n";
		$this->content .= "\t\t" . 'var points=[tableau.length, 2];'."\n";
		$this->content .= "\t\t" . 'for (var i=0; i<tableau.length-1; i++) {'."\n";
		$this->content .= "\t\t" . 'points[i]=tableau[i].split(";");'."\n";
		$this->content .= "\t\t" . '}'."\n";
		$this->content .= "\t\t" . 'for(var i=0; i<points.length; i++){'."\n";
		$this->content .= "\t\t" . 'var temp = new google.maps.LatLng(points[i][0], points[i][1]);'."\n";
		$this->content .= "\t\t" . 'tab[i]=temp;'."\n";
		$this->content .= "\t\t" . '}'."\n";
        $this->content .= "\t\t" . 'var _waypoints = new Array();'."\n";
		$this->content .= "\t\t" . 'if (tab.length > 2) //Waypoints will be come.'."\n";
		$this->content .= "\t\t" . '{'."\n";
		$this->content .= "\t\t" . 'for (var j = 1; j < tab.length - 1; j++) {'."\n";
		$this->content .= "\t\t" . '	var address = tab[j];'."\n";
		$this->content .= "\t\t" . 'if (address !== "") {'."\n";
		$this->content .= "\t\t" . ''."\n";
	    $this->content .= "\t\t" . '_waypoints.push({'."\n";
		$this->content .= "\t\t" . 'location: address,'."\n";
		$this->content .= "\t\t" . 'stopover: true  //stopover is used to show marker on map for waypoints'."\n";
		$this->content .= "\t\t" . '});'."\n";
        $this->content .= "\t\t" . '}'."\n";
        $this->content .= "\t\t" . '}'."\n";
        $this->content .= "\t\t" . 'addDirectionPoints(tab[0], tab[tab.length - 1], _waypoints);'."\n";
		$this->content .= "\t\t" . '}'."\n";
		$this->content .= "\t\t" . '}'."\n";
		
        // JS public function to set direction for many points
        $this->content .= "\t" . 'function addDirectionPoints(from,to, points) {' . "\n";
        //on commence par creer le polygone de points 
		$this->content .= "\t\t" . 'var request = {' . "\n";
        $this->content .= "\t\t" . 'origin:from, ' . "\n";
        $this->content .= "\t\t" . 'destination:to,' . "\n";
		$this->content .= "\t\t" . 'waypoints:points,' . "\n";
		$this->content .= "\t\t" . 'optimizeWaypoints: true,' . "\n";
        $this->content .= "\t\t" . 'travelMode: google.maps.DirectionsTravelMode.DRIVING' . "\n";
        $this->content .= "\t\t" . '};' . "\n";
        $this->content .= "" . "\n";
        $this->content .= "\t\t" . 'directionsService.route(request, function(response, status) {' . "\n";
        $this->content .= "\t\t" . 'if (status == google.maps.DirectionsStatus.OK) {' . "\n";
        $this->content .= "\t\t" . 'directions.setDirections(response);' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . '});' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to show a marker
        $this->content .= "\t" . 'function showMarker(id) {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'if (gmarkers[i].id == id) {' . "\n";
        $this->content .= "\t\t\t\t" . ' google.maps.event.trigger(gmarkers[i],\'click\');' . "\n";
        $this->content .= "\t\t\t" . '}' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to show a category of marker
        $this->content .= "\t" . 'function showCategory(category) {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'if (gmarkers[i].mycategory == category) {' . "\n";
        $this->content .= "\t\t\t\t" . 'gmarkers[i].setVisible(true);' . "\n";
        $this->content .= "\t\t\t" . '}' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to hide a category of marker
        $this->content .= "\t" . 'function hideCategory(category) {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'if (gmarkers[i].mycategory == category) {' . "\n";
        $this->content .= "\t\t\t\t" . 'gmarkers[i].setVisible(false);' . "\n";
        $this->content .= "\t\t\t" . '}' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to hide all the markers
        $this->content .= "\t" . 'function hideAll() {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'gmarkers[i].setVisible(false);' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to show all the markers
        $this->content .= "\t" . 'function showAll() {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'gmarkers[i].setVisible(true);' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function to hide/show a category of marker - TODO BUG
        $this->content .= "\t" . 'function toggleHideShow(category) {' . "\n";
        $this->content .= "\t\t" . 'for (var i=0; i<gmarkers.length; i++) {' . "\n";
        $this->content .= "\t\t\t" . 'if (gmarkers[i].mycategory === category) {' . "\n";
        $this->content .= "\t\t\t\t" . 'if (gmarkers[i].getVisible()===true) { gmarkers[i].setVisible(false); }' . "\n";
        $this->content .= "\t\t\t\t" . 'else gmarkers[i].setVisible(true);' . "\n";
        $this->content .= "\t\t\t" . '}' . "\n";
        $this->content .= "\t\t" . '}' . "\n";
        $this->content .= "\t\t" . 'if(infowindow) { infowindow.close(); }' . "\n";
        $this->content .= "\t" . '}' . "\n";

        // JS public function add a KML
        $this->content .= "\t" . 'function addKML(file) {' . "\n";
        $this->content .= "\t\t" . 'var ctaLayer = new google.maps.KmlLayer(file);' . "\n";
        $this->content .= "\t\t" . 'ctaLayer.setMap(map' . $this->googleMapId . ');' . "\n";
        $this->content .= "\t" . '}' . "\n";
    }

    /**
     * Generate the HTML code of the gmap
     */
    public function generate() {
        $this->init();

        //Fonction init()
        $this->content .= "\t" . 'function initialize' . $this->googleMapId . '() {' . "\n";
        $this->content .= "\t" . 'var myLatlng = new google.maps.LatLng(48.8792,2.34778);' . "\n";
        $this->content .= "\t" . 'var myOptions = {' . "\n";
        $this->content .= "\t\t" . 'zoom: ' . $this->zoom . ',' . "\n";
        $this->content .= "\t\t" . 'center: myLatlng,' . "\n";
        $this->content .= "\t\t" . 'mapTypeId: google.maps.MapTypeId.' . $this->mapType . "\n";
        $this->content .= "\t" . '}' . "\n";

        //Goole map Div Id
        $this->content .= "\t" . 'map' . $this->googleMapId . ' = new google.maps.Map(document.getElementById("' . $this->googleMapId . '"), myOptions);' . "\n";

        // Center
        if ($this->enableAutomaticCenterZoom == TRUE) {
            $lenLng = $this->maxLng - $this->minLng;
            $lenLat = $this->maxLat - $this->minLat;
            $this->minLng -= $lenLng * $this->coordCoef;
            $this->maxLng += $lenLng * $this->coordCoef;
            $this->minLat -= $lenLat * $this->coordCoef;
            $this->maxLat += $lenLat * $this->coordCoef;

            $minLat = number_format(floatval($this->minLat), 12, '.', '');
            $minLng = number_format(floatval($this->minLng), 12, '.', '');
            $maxLat = number_format(floatval($this->maxLat), 12, '.', '');
            $maxLng = number_format(floatval($this->maxLng), 12, '.', '');
            $this->content .= "\t\t\t" . 'var bds = new google.maps.LatLngBounds(new google.maps.LatLng(' . $minLat . ',' . $minLng . '),new google.maps.LatLng(' . $maxLat . ',' . $maxLng . '));' . "\n";
            $this->content .= "\t\t\t" . 'map' . $this->googleMapId . '.fitBounds(bds);' . "\n";
        } else {
            if ($this->enableGeolocation === TRUE) {
                $this->content .= "\t" . 'if(navigator.geolocation) {' . "\n";
                $this->content .= "\t\t" . 'navigator.geolocation.getCurrentPosition(function(position) {' . "\n";
                $this->content .= "\t\t" . 'var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);' . "\n";
                $this->content .= "\t\t" . 'map' . $this->googleMapId . '.setCenter(pos);' . "\n";
                $this->content .= "\t\t" . '},function() { geocodeCenter("' . $this->center . '"); } );' . "\n";
                $this->content .= "\t" . '}' . "\n";
            } elseif (isset($this->centerLatLng)) {
                $this->content .= "\t" . 'map' . $this->googleMapId . '.setCenter(' . $this->centerLatLng . ');' . "\n";
            } else {
                $this->content .= "\t" . 'geocodeCenter("' . $this->center . '");' . "\n";
            }
        }


        $this->content .= "\t" . 'google.maps.event.addListener(map' . $this->googleMapId . ',"click",function(event) { if (event) { current_lat=event.latLng.lat();current_lng=event.latLng.lng(); }}) ;' . "\n";

        $this->content .= "\t" . 'directions.setMap(map' . $this->googleMapId . ');' . "\n";
        $this->content .= "\t" . 'directions.setPanel(document.getElementById("' . $this->googleMapDirectionId . '"))' . "\n";

        // add all the markers
        $this->content .= $this->contentMarker;

        // Clusterer JS
        if ($this->useClusterer == TRUE) {
            $this->content .= "\t" . 'var markerCluster = new MarkerClusterer(map' . $this->googleMapId . ', gmarkers,{gridSize: ' . $this->gridSize . ', maxZoom: ' . $this->maxZoom . '});' . "\n";
        }

        $this->content .= '}' . "\n";

        // Chargement de la map a la fin du HTML
        //$this->content.= "\t".'window.onload=initialize;'."\n";
        $this->content .= "\t" . 'addLoadEvent(initialize' . $this->googleMapId . ');' . "\n";

        //Fermeture du javascript
        $this->content .= '</script>' . "\n";
    }

    /**
     * ajout� par Patrick SANANG
     * */
    function get_coordinates($city, $street, $province) {
        $address = urlencode($city . ',' . $street . ',' . $province);
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Poland";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $status = $response_a->status;

        if ($status == 'ZERO_RESULTS') {
            return FALSE;
        } else {
            $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
            return $return;
        }
    }

    /**
     * adds a map polyline by map coordinates
     * if color, weight and opacity are not defined, use the google maps defaults
     * 
     * @param string $lon1 the map longitude to draw from
     * @param string $lat1 the map latitude to draw from
     * @param string $lon2 the map longitude to draw to
     * @param string $lat2 the map latitude to draw to
     * @param string $color the color of the line (format: #000000)
     * @param string $weight the weight of the line in pixels
     * @param string $opacity the line opacity (percentage)
     */
    public function addPolyLineByCoords($lon1, $lat1, $lon2, $lat2, $color = '', $weight = 0, $opacity = 0) {
        $_polyline['lon1'] = $lon1;
        $_polyline['lat1'] = $lat1;
        $_polyline['lon2'] = $lon2;
        $_polyline['lat2'] = $lat2;
        $_polyline['color'] = $color;
        $_polyline['weight'] = $weight;
        $_polyline['opacity'] = $opacity;
        $this->_polylines[] = $_polyline;
        $this->adjustCenterCoords($_polyline['lon1'], $_polyline['lat1']);
        $this->adjustCenterCoords($_polyline['lon2'], $_polyline['lat2']);
        // return index of polyline
        $this->getPolylineJS();
        return count($this->_polylines) - 1;
    }

    /**
     * overridable function to generate polyline js
     */
    function getPolylineJS() {
        $_output = '';
        foreach ($this->_polylines as $_polyline) {
            $_output .= sprintf('var polyline = new GPolyline([new GLatLng(%s,%s),new GLatLng(%s,%s)],"%s",%s,%s);', $_polyline['lat1'], $_polyline['lon1'], $_polyline['lat2'], $_polyline['lon2'], $_polyline['color'], $_polyline['weight'], $_polyline['opacity'] / 100.0) . "\n";
            $_output .= 'map.addOverlay(polyline);' . "\n";
        }
        return $_output;
    }

    /**
     * adjust map center coordinates by the given lat/lon point
     * 
     * @param string $lon the map latitude (horizontal)
     * @param string $lat the map latitude (vertical)
     */
    function adjustCenterCoords($lon, $lat) {
        if (strlen((string) $lon) == 0 || strlen((string) $lat) == 0)
            return false;
        $this->maxLng = (float) max($lon, $this->maxLng);
        $this->minLng = (float) min($lon, $this->minLng);
        $this->maxLat = (float) max($lat, $this->maxLat);
        $this->minLat = (float) min($lat, $this->minLat);

        $this->centerLng = (float) ($this->minLng + $this->maxLng) / 2;
        $this->centerLat = (float) ($this->minLat + $this->maxLat) / 2;
        return true;
    }

    /**
     * get distance between to geocoords using great circle distance formula
     * 
     * @param float $lat1
     * @param float $lat2
     * @param float $lon1
     * @param float $lon2
     * @param float $unit   M=miles, K=kilometers, N=nautical miles, I=inches, F=feet
     */
    function geoGetDistance($lat1, $lon1, $lat2, $lon2, $unit = 'M') {

        // calculate miles
        $M = 69.09 * rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1 - $lon2))));

        switch (strtoupper($unit)) {
            case 'K':
                // kilometers
                return $M * 1.609344;
                break;
            case 'N':
                // nautical miles
                return $M * 0.868976242;
                break;
            case 'F':
                // feet
                return $M * 5280;
                break;
            case 'I':
                // inches
                return $M * 63360;
                break;
            case 'M':
            default:
                // miles
                return $M;
                break;
        }
    }

    function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
        $theta = abs($lon1 - $lon2);
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * (pi() / 2);
        $kilometers = $miles * 1.609344;
        return $kilometers;
    }

    function GetDrivingDistance($lat1, $lat2, $long1, $long2) {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist, 'time' => $time);
    }

    function get_distance($lat1, $lat2, $long1, $long2) {
        /* These are two points in New York City */
        $point1 = array('lat' => $lat1, 'long' => $long1);
        $point2 = array('lat' => $lat2, 'long' => $long2);

        $distance = $this->getDistanceBetweenPoints($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
        return $distance;
    }

}
