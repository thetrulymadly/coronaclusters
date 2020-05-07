<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace App\Http\Controllers;

use Api\Services\CovidDataService;
use App\Models\CovidRawData;
use App\Models\CovidStateData;
use App\Models\CovidTesting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CoronaController
 * @package App\Http\Controllers
 */
class CoronaController extends Controller
{

    /**
     * @var \Api\Services\CovidDataService
     */
    private $covidDataService;

    /**
     * CoronaController constructor.
     *
     * @param \Api\Services\CovidDataService $covidDataService
     */
    public function __construct(CovidDataService $covidDataService)
    {
        $this->covidDataService = $covidDataService;
    }

    public function home()
    {
        // ------------------- State data ------------------- //
        $stateData = $this->getStateData();

        // ------------------- Aggregate data ------------------- //
        $aggregateData = $stateData->where('state', 'Total')->first();
        $aggregateData = [
            'confirmed' => $aggregateData->confirmed ?? 0,
            'active' => $aggregateData->active ?? 0,
            'recovered' => $aggregateData->recovered ?? 0,
            'deaths' => $aggregateData->deaths ?? 0,
            'delta_confirmed' => $aggregateData->delta_confirmed ?? 0,
            'delta_active' => $aggregateData->delta_active ?? 0,
            'delta_recovered' => $aggregateData->delta_recovered ?? 0,
            'delta_deaths' => $aggregateData->delta_deaths ?? 0,
        ];

        $aggregateData['location'] = trans('corona.places.india');
        $date = CovidRawData::max('created_at');
        $format = 'Y-m-d H:i:s';
        $aggregateData['time_ago'] = Helpers::getTimeAgo($date, $format);
        // Format the date
        $date = explode(' ', $date);
        $aggregateData['last_update_date'] = Carbon::createFromFormat(explode(' ', $format)[0], $date[0])->toDateString();
        $aggregateData['last_update_time'] = $date[1] ?? '';

        // ------------------- Page meta data ------------------- //
        // Replace the number placeholder with the actual count
        $title = trans('corona.page.home.title', $aggregateData);
        $description = trans('corona.page.home.meta.description', $aggregateData);
        $keywords = trans('corona.page.home.meta.keywords', $aggregateData);
        $url = request()->url();
        $templateType = 'country';
        $mapCenter = [];
        $timeline = null;
        // Breadcrumbs
        $breadcrumbs = $this->getBreadcrumbs();

        $locations = [];
        $districtData = [];
        $cityData = [];

        return view('index',
            compact('stateData', 'districtData', 'cityData', 'aggregateData', 'timeline', 'title', 'description', 'url', 'keywords',
                'templateType', 'mapCenter', 'breadcrumbs'));
    }

    /**
     * @param $string
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $string = '')
    {
        // ------------------- Data Processing ------------------- //

        // Parse the path to extract city/state
        $path = request()->canonicalPath;
        if (count(array_filter(explode('/', $path))) > 1) {
            $city = substr($string, strrpos($string, '/') + 1);
            $state = substr($string, 0, strrpos($string, '/'));
        } else {
            $city = '';
            $state = $string;
        }

        $state = Helpers::beautify($state);
        $city = Helpers::beautify($city);
        $rawData = $this->covidDataService->getRawData(null, $state, $city);
        if (!empty($string) && $rawData->isEmpty()) {
            throw new NotFoundHttpException();
        }

        if (!empty($city)) {
            $active = $rawData->where('currentstatus', 'Hospitalized')->count();
            $recovered = $rawData->where('currentstatus', 'Recovered')->count();
            $deaths = $rawData->where('currentstatus', 'Deceased')->count();

            $aggregateData = [
                'confirmed' => $active + $recovered + $deaths,
                'active' => $active,
                'recovered' => $recovered,
                'deaths' => $deaths,
            ];
            $templateType = 'city';
        } else {
            $stateData = $this->getStateData($state ?? '');
            $aggregateData = $stateData->where('state', $state ?? 'Total')->first();

            $aggregateData = [
                'confirmed' => $aggregateData->confirmed ?? 0,
                'active' => $aggregateData->active ?? 0,
                'recovered' => $aggregateData->recovered ?? 0,
                'deaths' => $aggregateData->deaths ?? 0,
                'delta_confirmed' => $aggregateData->delta_confirmed ?? 0,
                'delta_active' => $aggregateData->delta_active ?? 0,
                'delta_recovered' => $aggregateData->delta_recovered ?? 0,
                'delta_deaths' => $aggregateData->delta_deaths ?? 0,
            ];

            if (empty($state)) {
                $stateData = $stateData->toArray();
                $templateType = 'country';
            } else {
                $templateType = 'state';

                $districts = $rawData->groupBy('detecteddistrict');
                $districtData = $this->getDataFromGroups($districts);

                $cities = $rawData->groupBy('detectedcity');
                $cityData = $this->getDataFromGroups($cities);
            }
        }

        $stateData = $stateData ?? [];
        $districtData = $districtData ?? [];
        $cityData = $cityData ?? [];

        // Find the center of the map
        $mapCenter = [];
        if (!empty($string)) {
            if (!empty($city)) {
                $mapCenter = $rawData->where('detectedcity', $city)->first();
            } else {
                $mapCenter = $rawData->where('detectedstate', $state)->first();
            }
            $mapCenter = $mapCenter->geo_city ?? $mapCenter->geo_district ?? $mapCenter->geo_state ?? $mapCenter->geo_country ?? [];
        }

        // ------------------- Meta data ------------------- //

        $urlArray = array_filter(explode('/', request()->canonicalPath));

        // Create a url to depict the text for current location of the page
        $location = '';
        $loc = $urlArray;
        while (!empty($loc)) {
            $location .= array_pop($loc);
            if (!empty($loc)) {
                $location .= ', ';
            }
        }
        $location = ucwords(!empty($location) ? $location : trans('corona.places.india'));

        $aggregateData['location'] = $location;
        [$date, $format] = $this->getLastUpdatedTime($rawData);
        $aggregateData['time_ago'] = Helpers::getTimeAgo($date, $format);
        // Format the date
        $date = explode(' ', $date);
        $aggregateData['last_update_date'] = Carbon::createFromFormat(explode(' ', $format)[0], $date[0])->toDateString();
        $aggregateData['last_update_time'] = $date[1] ?? '';

        // ------------------- Page meta data ------------------- //

        // Replace the number placeholder with the actual count
        $title = trans('corona.page.home.title', $aggregateData);
        $description = trans('corona.page.home.meta.description', $aggregateData);
        $keywords = trans('corona.page.home.meta.keywords', $aggregateData);
        $url = request()->url();

        // Breadcrumbs
        $breadcrumbs = $this->getBreadcrumbs();

        // History
        $timeline = null;
//        $timeline = array_slice($timeline, 0, 3);

        return view('index',
            compact('rawData', 'stateData', 'districtData', 'cityData', 'aggregateData', 'timeline', 'title', 'description', 'url', 'keywords',
                'templateType', 'mapCenter', 'breadcrumbs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testing()
    {
        $tests = CovidTesting::where('totalsamplestested', '!=', 0)
            ->orderBy('totalsamplestested', 'asc')
            ->get();

        $dailyTests = [];
        $testsArray = $tests->toArray();
        $testCount = count($testsArray);

        $prev = [];
        for ($i = 0; $i < $testCount; $i++) {
            // Settle the heads first
            $prev['totalindividualstested'] = $testsArray[$i]['totalindividualstested'] > 0 ? $testsArray[$i]['totalindividualstested'] : $prev['totalindividualstested'] ?? 0;
            $prev['totalpositivecases'] = $testsArray[$i]['totalpositivecases'] > 0 ? $testsArray[$i]['totalpositivecases'] : $prev['totalpositivecases'] ?? 0;
            $prev['totalsamplestested'] = $testsArray[$i]['totalsamplestested'] > 0 ? $testsArray[$i]['totalsamplestested'] : $prev['totalsamplestested'] ?? 0;

            if ($i - 1 >= 0) { // All iterations

//                $currDate = Carbon::parse($testsArray[$i]['updatetimestamp'])->toDateString();
//                $prevDate = Carbon::parse($testsArray[$i - 1]['updatetimestamp'])->toDateString();
//                if ($currDate == $prevDate) {
//                    $prev['today_totalindividualstested'] = $prev['today_totalindividualstested'] + $testsArray[$i]['totalindividualstested'] - $testsArray[$i - 1]['totalindividualstested'];
//                    $prev['today_totalpositivecases'] = $prev['today_totalpositivecases'] + $testsArray[$i]['totalpositivecases'] - $testsArray[$i - 1]['totalpositivecases'];
//                    $prev['today_totalsamplestested'] = $prev['today_totalsamplestested'] + $testsArray[$i]['totalsamplestested'] - $testsArray[$i - 1]['totalsamplestested'];
//
//                    continue;
//                }

                $peopleTested = $testsArray[$i]['totalindividualstested'] - $testsArray[$i - 1]['totalindividualstested'];
                $peoplePositive = $testsArray[$i]['totalpositivecases'] - $testsArray[$i - 1]['totalpositivecases'];
                $sampleTested = $testsArray[$i]['totalsamplestested'] - $testsArray[$i - 1]['totalsamplestested'];
//                $percentIncreasePositive = (($testsArray[$i]['totalpositivecases'] - $testsArray[$i + 1]['totalpositivecases']) / $testsArray[$i]['totalpositivecases']) * 100;
//                $percentIncreaseTested = (($testsArray[$i]['totalindividualstested'] - $testsArray[$i + 1]['totalindividualstested']) / $testsArray[$i]['totalindividualstested']) * 100;

            } else { // The first iteration
                $peopleTested = $prev['today_totalindividualstested'] = $testsArray[$i]['totalindividualstested'];
                $peoplePositive = $prev['today_totalpositivecases'] = $testsArray[$i]['totalpositivecases'];
                $sampleTested = $prev['today_totalsamplestested'] = $testsArray[$i]['totalsamplestested'];
//                $percentIncreaseTested = $percentIncreasePositive = 0;
            }

            $prev['today_totalindividualstested'] = $peopleTested > 0 ? $peopleTested : $prev['today_totalindividualstested'];
            $prev['today_totalpositivecases'] = $peoplePositive > 0 ? $peoplePositive : $prev['today_totalpositivecases'];
            $prev['today_totalsamplestested'] = $sampleTested > 0 ? $sampleTested : $prev['today_totalsamplestested'];

            $dailyTests[] = [
                'totalindividualstested' => $prev['totalindividualstested'],
                'totalsamplestested' => $prev['totalsamplestested'],
                'totalpositivecases' => $prev['totalpositivecases'],
                'today_totalindividualstested' => $prev['today_totalindividualstested'],
                'today_totalpositivecases' => $prev['today_totalpositivecases'],
                'today_totalsamplestested' => $prev['today_totalsamplestested'],
                'today_totalpositivecases_percent' => round((($prev['today_totalpositivecases'] ?? 0) / ($prev['today_totalindividualstested'] ?? 0)) * 100,
                        2) . '%',
//                'today_totalsamplestested_percent' => round((($peoplePositive ?? 0) / ($peopleTested ?? 0)) * 100, 2) . '%',
//                'percent_increase_tested' => round($percentIncreaseTested, 2) . '%',
//                'percent_increase_positive' => round($percentIncreasePositive, 2) . '%',
                'updatetimestamp' => Carbon::parse($testsArray[$i]['updatetimestamp'])->toDateString(),
                'source' => $testsArray[$i]['source'],
            ];
        }

        $topTests = CovidTesting::where('totalsamplestested', '!=', 0)
            ->orderBy('totalsamplestested', 'desc')
            ->limit(2)
            ->get()->toArray();

        $stats = [
            'total_samples' => $topTests[0]['totalsamplestested'],
//            'total_tested' => $topTests[0]['totalindividualstested'],
//            'total_positive' => $topTests[0]['totalpositivecases'],
//            'total_positive_percent' => round(($topTests[0]['totalpositivecases'] / $topTests[0]['totalindividualstested']) * 100, 2) . '%',
//            'delta_total_tested' => $topTests[0]['totalindividualstested'] - $topTests[1]['totalindividualstested'],
//            'delta_total_positive' => $topTests[0]['totalpositivecases'] - $topTests[1]['totalpositivecases'],
            'delta_total_samples' => $topTests[0]['totalsamplestested'] - $topTests[1]['totalsamplestested'],
            'last_testing_on' => $topTests[0]['updatetimestamp'],
        ];

        // Breadcrumbs
        $breadcrumbs = $this->getBreadcrumbs();

        $title = trans('corona.page.testing.title', $stats);
        $description = trans('corona.page.testing.meta.description', $stats);
        $url = request()->url();
        $keywords = trans('corona.page.testing.meta.keywords', $stats);

        return view('testing', compact('dailyTests', 'stats', 'breadcrumbs', 'title', 'description', 'url', 'keywords'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timeline()
    {
        $path = request()->canonicalPath;
        $timelinePlace = array_filter(explode('/', substr($path, 0, strpos($path, '/timeline'))));

        if (!empty($timelinePlace)) {
            $timeline = $this->createTimeline($timelinePlace[0], $timelinePlace[1] ?? null);
            // Create a url to depict the text for current location of the page
            $location = '';
            while (!empty($timelinePlace)) {
                $location .= array_pop($timelinePlace);
                if (!empty($timelinePlace)) {
                    $location .= ', ';
                }
            }
            $location = trans('places.' . $timelinePlace[0]);
        } else {
            $timeline = $this->createTimeline(null, null);
            $location = trans('places.india');
        }

        $breadcrumbs = $this->getBreadcrumbs();
        $title = trans('corona.timeline_title', ['location' => $location]);
        $description = trans('corona.timeline_description', ['location' => $location]);
        $keywords = trans('corona.timeline_keywords');
        $url = request()->url();

        return view('timeline', compact('timeline', 'location', 'title', 'description', 'url', 'keywords', 'breadcrumbs'));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|null $data
     * @param string $state
     * @param string $city
     *
     * @return \Illuminate\Database\Eloquent\Builder|null
     */
    private function makeRawDataQuery(?Builder $data, ?string $state = '', ?string $city = '')
    {
        if ($data === null) {
            $data = CovidRawData::query();
        }

        if (!empty($city)) {
            $data->where('detectedcity', $city);
            $data->orWhere('detectedDistrict', $city);
        }
        if (!empty($state)) {
            $data->where('detectedstate', $state);
        }

        return $data;
    }

    /**
     * @param string $state
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getStateData(string $state = '')
    {
        $data = CovidStateData::query();
        if (!empty($state)) {
            $data->where('state', $state);
        }

        return $data->get();
    }

    /**
     * @param $groups
     *
     * @return array
     */
    private function getDataFromGroups($groups)
    {
        $data = [];
        foreach ($groups as $key => $items) {
            // Active & its delta
            $active = $items->where('currentstatus', 'Hospitalized');
            $delta_active = $active->where('statuschangedate', '=', Carbon::today()->format('d/m/Y'))->count();
            $active = $active->count();

            // Recovered & its delta
            $recovered = $items->where('currentstatus', 'Recovered');
            $delta_recovered = $recovered->where('statuschangedate', '=', Carbon::today()->format('d/m/Y'))->count();
            $recovered = $recovered->count();

            // Deaths & its delta
            $deaths = $items->where('currentstatus', 'Deceased');
            $delta_deaths = $deaths->where('statuschangedate', '=', Carbon::today()->format('d/m/Y'))->count();
            $deaths = $deaths->count();

            // Confirmed & its delta
            $confirmed = $active + $recovered + $deaths;
            $delta_confirmed = $delta_active + $delta_recovered + $delta_deaths;

            $lastupdatedtime = $items->max('statuschangedate');

            $city = $state = $district = $key;
            $data[] = compact('city', 'district', 'state', 'active', 'delta_active', 'recovered', 'delta_recovered', 'deaths', 'delta_deaths',
                'confirmed', 'delta_confirmed', 'lastupdatedtime');
        }

        return $data;
    }

    /**
     * @param $rawData
     *
     * @return array
     */
    private function getLastUpdatedTime($rawData)
    {
        $date = $rawData->max('created_at')->toDateTimeString();
        $format = 'Y-m-d H:i:s';

//        if (Carbon::now()->toDateString() == Carbon::createFromFormat('d/m/Y', $rawData->max('dateannounced'))->toDateString()) {
//            $date = $rawData->where('dateannounced', $date)->max('updated_at')->toDateTimeString();
//            $format = 'Y-m-d H:i:s';
//        }

        return [$date, $format];
    }

    /**
     * @param string|null $state
     * @param string|null $city
     *
     * @return array
     */
    private function createTimeline(?string $state, ?string $city)
    {
        $source1 = CovidRawData::whereNotNull('source1')
            ->where('source1', '!=', '')
            ->select('id', 'patientnumber', 'source1 as source', 'dateannounced', 'detectedstate', 'detecteddistrict', 'detectedcity');
        $source1 = $this->makeRawDataQuery($source1, $state, $city);

        $source2 = CovidRawData::whereNotNull('source2')
            ->where('source2', '!=', '')
            ->select('id', 'patientnumber', 'source2 as source', 'dateannounced', 'detectedstate', 'detecteddistrict', 'detectedcity');
        $source2 = $this->makeRawDataQuery($source2, $state, $city);

        $results = CovidRawData::whereNotNull('source3')
            ->where('source3', '!=', '')
            ->select('id', 'patientnumber', 'source3 as source', 'dateannounced', 'detectedstate', 'detecteddistrict', 'detectedcity')
            ->unionAll($source1)
            ->unionAll($source2)
            ->orderBy('id', 'desc');
        $results = $this->makeRawDataQuery($results, $state, $city)->get();

        $results = $results->groupBy('dateannounced');

        $output = [];
        foreach ($results as $date => $result) {
            if (empty($date)) {
                continue;
            }
            $date = Carbon::createFromFormat('d/m/Y', $date)->format('d M Y');
            $output[$date] = $result->groupBy('detectedstate');
            foreach ($output[$date] as $state) {
                $state->push($state->count());
            }
            $output[$date]['total'] = $result->count();
        }

        return $output;
    }
}
