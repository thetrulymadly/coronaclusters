<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

return [
    'active' => 'Active',
    'agebracket' => 'Age Bracket',
    'backupnotes' => 'Backup Notes',
    'city' => 'City',
    'clusters' => 'Clusters',
    'confirmed' => 'Confirmed',
    'contractedfromwhichpatientsuspected' => 'Contracted From (suspected)',
    'corona_testing' => 'Testing',
    'currentstatus' => 'Current Status',
    'data' => 'Data',
    'dateannounced' => 'Date Announced',
    'deaths' => 'Deaths',
    'delta_active' => 'Delta Active',
    'delta_confirmed' => 'New Cases',
    'delta_deaths' => 'New Deaths',
    'delta_recovered' => 'Delta Recovered',
    'detectedcity' => 'Detected City',
    'detecteddistrict' => 'Detected District',
    'detectedstate' => 'Detected State',
    'district' => 'District',
    'estimatedonsetdate' => 'Estimated on set Date',
    'gender' => 'Gender',
    'help_links' => 'Helpful Links',
    'lastupdatedtime' => 'Last Updated',
    'nationality' => 'Nationality',
    'notes' => 'Notes',
    'lastest_update_text' => 'Last case recorded in :location - :time_ago',
    'advisory_text' => [
        'text1' => 'Going out to buy essentials? Social Distancing is KEY! Maintain 2 metres distance between each other in the line.',
        'text2' => 'Lockdown means LOCKDOWN! Avoid going out unless absolutely necessary. Stay safe!',
        'text3' => '',
        'text4' => '',
    ],
    'map_notes' => [
        'note1' => 'Please note: Location is indicative of the city/district and not exact pin-point.',
        'note2' => 'Tap on a cluster to zoom-in.',
    ],
    'title' => '<span class="text-primary">Corona</span> <span class="text-secondary">India</span> Tracker',
    'page' =>
        [
            'home' =>
                [
                    'h1' => 'Corona Update (Live) : :delta_confirmed new cases in :location today',
                    'meta' =>
                        [
                            'description' => 'Get Live updated news of Corona Virus Cases in :location. There are total :confirmed confirmed cases of Covid19 in :location, out of which :recovered have recovered, :active are still hospitalized and unfortunately :deaths deaths have been recorded in :location till :last_update_date. The last corona case in :location was reported :time_ago in :district district. For more Corona News and Live Stats visit CoronaClusters.in',
                            'keywords' => 'Corona Cases, Covid Cases, Coronavirus Cases, Corona Cases in :location, Corona Deaths in :location, corona cases by states india, covid cases in :location, covid deaths in :location, covid death rate in :location, covid recovery rate in :location, corona death rate in :location, corona recovery rate in :location, coronavirus death rate in :location, coronavirus recovery rate in :location, Coronavirus Cases in :location, Coronavirus Deaths in :location, coronavirus cases by states india',
                        ],
                    'p1' => ':confirmed people are so far affected in :location by novel coronavirus covid-19. :recovered out of :confirmed have recovered. Sadly, :deaths patients have died due to coronavirus in :location. :active patients are still in hospital and recovering. The last recorded case of coronavirus in :location was :time_ago. Below is the list of sources from which data is aggregated into a crowdsourced patient database along with some note on travel history and suspected contraction from another patient if any. All data is verified by a group of volunteers at Covid19India.org after aggregating from various district and state level health bulletins and other reliable sources.',
                    'title' => 'Covid-19 :location Update (LIVE) : :confirmed Cases and :deaths Deaths from Coronavirus Outbreak in India - Corona Clusters | Historical Data & Daily Charts of Corona Virus in Indian States',
                ],
            'testing' =>
                [
                    'h1' => 'Corona Testing per Day in India',
                    'meta' =>
                        [
                            'description' => 'Get live updated testing numbers of Corona Virus Testing in India. There are total of :total_samples tests done so far in India of :total_tested individuals. :total_positive tests have come our positive so far. For more corona stats visit CoronaClusters.in',
                            'keywords' => 'Corona Virus Testing, Corona Virus Testing Per day in India, Corona Tests in India, Covid Virus Testing, Covid Virus Testing Per day in India, Covid Tests in India',
                        ],
                    'title' => 'Corona Virus Testing in India | Covid-19 Testing per day - India - :total_samples Tests of :total_tested individuals have been done in India so far. :total_positive confirmed positive corona cases so far in India - CoronaClusters.in',
                ],
        ],
    'patientnumber' => 'Patient Number',
    'percent_increase_positive' => 'Increase in Positive Cases',
    'percent_increase_tested' => 'Increase in Testing',
    'places' =>
        [
            'india' => 'India',
            'some_area' => 'the area',
        ],
    'recovered' => 'Recovered',
    'source' => 'Source',
    'source1' => 'Source 1',
    'source2' => 'Source 2',
    'source3' => 'Source 3',
    'state' => 'State',
    'statepatientnumber' => 'State Patient Number',
    'statuschangedate' => 'Status Change Date',
    'table_active' => 'Active Cases',
    'table_city' => 'City',
    'table_confirmed' => 'Total Cases',
    'table_deaths' => 'Total Deaths',
    'table_delta_active' => 'Delta Active',
    'table_delta_confirmed' => 'New Cases',
    'table_delta_deaths' => 'New Deaths',
    'table_delta_recovered' => 'Delta Recovered',
    'table_district' => 'District',
    'table_lastupdatedtime' => 'Last Updated',
    'table_recovered' => 'Total Recovered',
    'table_state' => 'State',
    'time' =>
        [
            'days_ago' => 'day ago|days ago',
            'hours_ago' => 'hour ago|hours ago',
            'just_now' => 'just now',
            'minutes_ago' => 'minute ago|minutes ago',
            'months_ago' => 'months ago|months ago',
            'seconds_ago' => 'second ago|seconds ago',
            'years_ago' => 'year ago|years ago',
        ],
    'total_positive' => 'Positive for COVID',
    'total_tested' => 'Patients Tested',
    'totalindividualstested' => 'Patients Tested',
    'today_totalindividualstested' => 'Patients Tested So Far',
    'totalpositivecases' => 'Positive so far',
    'today_totalpositivecases' => 'Positive',
    'totalsamplestested' => 'Tested So Far',
    'today_totalsamplestested' => 'New',
    'today_totalpositivecases_percent' => '% Positive',
    'total_positive_percent' => 'Total % Positive',
    'total_samples' => 'Samples Tested',
    'unknown' => 'Unknown',
    'updatetimestamp' => 'Tested On',

    'raw_data' => 'City-wise Data',
    'city_wise_data' => 'City-wise Data',
    'district_wise_data' => 'District-wise Data',
    'state_wise_data' => 'State-wise Data',

    'footer' => [
        'title_help_links' => 'Helpful Links',
        'title_sources' => 'Sources',
        'link_mohfw' => 'Ministry of Health and Family Welfare, Gov. of India',
        'link_mohfw_numbers' => 'MOHFW - HELPLINE NUMBERS [by State]',
        'link_who' => 'WHO: COVID-19 Home Page',
        'link_cdc' => 'Centers for Disease Control and Prevention (CDC)',
        'link_global_tracker' => 'COVID-19 Global Tracker',
        'link_crowdsource_db' => 'Crowdsourced Patient Database',
        'link_covid19_org' => 'APIs by Covid19India',
        'link_report_bug' => 'Report a bug',
        'link_sitemap' => 'Sitemap',
        'link_team_tm' => 'An effort by <a href="https://trulymadly.com/">Team TrulyMadly</a> to keep our loved ones safe and informed!',
    ],
    'testing' => [
        'latest_update_text' => 'Last COVID test performed on - :datetime',
    ],
    'timeline' => 'Timeline',
    'timeline_title' => 'COVID-19 :location Timeline',
    'timeline_link' => 'View complete timeline',
    'locales' => [
        'en' => 'English',
        'hi' => 'हिन्दी',
    ],

    'no_data' => 'No Data',
];
