<?php
/*
Plugin name: Country Details
Version: 1.0
Author: drsr
Description: Get information about any country on mouse move over the country using a simple short code, for ex: [countrydetails country="India"]. 
*/

/* Rename the country field names to readable format */
function cdrsr1231_rename_country_fields($countryField){
	//return $countryField;
	switch ($countryField) {
    case "name":
        return "Name";
        break;
    case "capital":
        return "Capital";
        break;
    case "altSpellings":
        return "Alternative Spellings";
        break;
	case "relevance":
        return "Relevance";
        break;
	case "region":
        return "Region";
        break;
	case "subregion":
        return "Sub Region";
        break;
	case "translations":
        return "Translations";
        break;
	case "population":
        return "population";
        break;
	case "latlng":
        return "Longitude & Latitude";
        break;
	case "demonym":
        return "Demonym";
        break;
	case "area":
        return "Area";
        break;
	case "gini":
        return "Gini Coefficient";
        break;
	case "timezones":
        return "Time Zones";
        break;
	case "borders":
        return "Borders";
        break;
	case "nativeName":
        return "Native Names";
        break;
	case "callingCodes":
        return "Calling Codes";
        break;
	case "topLevelDomains":
        return "Borders";
        break;
	case "alpha2Code":
        return "Alpha-2 Code";
        break;
	case "alpha3code":
        return "Alpha-3 Code";
        break;
	case "currencies":
        return "Currencies";
        break;
	case "languages":
        return "Languages";
        break;
	
}
}
/* Rename the country field names to readable format ends*/


/* Print the country data to the marquee */
			function cdrsr1231_build_country_info_scroller($key, $value){
			  if(function_exists("cdrsr1231_rename_country_fields")){
				if($key == 'translations'){
				} elseif(is_array($value)){
						$buildOutput = "<span class='tooltipheader1'>".cdrsr1231_rename_country_fields($key).'</span>'.implode(", ", $value);
						return $buildOutput;
				}else{
						$buildOutput = "<span class='tooltipheader1'>".cdrsr1231_rename_country_fields($key).'</span>'.$value;
						return $buildOutput;
				}
			  }	
			}
/* Print the country data to the marquee end */


/* 2nd function to call from shortcode and called from  drsr_country_info_display*/
function cdrsr1231_country_details_start($x){
						$json_file1 = file_get_contents('https://restcountries.eu/rest/v1/all');
						// convert the string to a json object
						$jfo1 = json_decode($json_file1);
						$allCountriesArray = $jfo1;
								?>
							<div class='drsrtooltip'></br> 
							<?php echo __($x); ?>
								<div style="display: inline-block;align:left;white-space: nowrap;">

									<?php 
										foreach($allCountriesArray as $singleCountryArray){
											if($x==$singleCountryArray->name){ ?>
											<span class="drsrtooltiptext">
											<marquee>
											<?php
													foreach($singleCountryArray as $key=>$value){
															
														if( function_exists( "cdrsr1231_build_country_info_scroller" ) ) {
															echo __(cdrsr1231_build_country_info_scroller($key, $value));
														}
													}
											?>
											</marquee>
											</span>
									  <?php }	
										} ?>
								</div>
							</div>
					<?php }
/* 2nd function to call from shortcode and called from  drsr_country_info_display ends*/

/* 1st function to call from shortcode and called from  add_shortcode();*/
function cdrsr1231_country_details_main($atts){	
										$a = shortcode_atts( array(
												'country' => 'India',
											), $atts );		
												
											if( function_exists( "cdrsr1231_country_details_start" ) ) {
												return cdrsr1231_country_details_start(esc_attr($a['country']));
											}
										}
add_shortcode( 'countrydetails', 'cdrsr1231_country_details_main' );
/* 1st function to call from shortcode and called from  add_shortcode(); ends*/

/* Registering css and js files*/
			
	function cdrsr1231_country_details_stylesheet(){ 
			wp_enqueue_style( 'style', 
								plugins_url('/styles.css', __FILE__)); 
	}
			add_action('init', 'cdrsr1231_country_details_stylesheet');
/* Registering css and js files ends*/