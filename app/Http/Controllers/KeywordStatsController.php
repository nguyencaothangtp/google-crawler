<?php


namespace App\Http\Controllers;

use App\KeywordStatistic;
use App\Exceptions\KeywordStatsException;
use Matthenning\EloquentApiFilter\Traits\FiltersEloquentApi;

class KeywordStatsController extends Controller
{
    use FiltersEloquentApi;

    public function get(int $id) {
        $keyStat =  KeywordStatistic::find($id);

        if (!$keyStat) {
            throw KeywordStatsException::notfound();
        }

        $keyStat['html'] = $keyStat['html_content']; // include hidden html_content in get single record

        return response()->json($keyStat);
    }

    public function list() {
        $query = KeywordStatistic::query();

        return $this->filterApiRequest($this->request, $query)->paginate(
            $this->request->get('per_page'),
            ['*'],
            'page',
            $this->request->get('page')
        );
    }
}
