<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class KeywordStatistic extends Model
{
    /** @var string */
    protected $table = 'keyword_statistics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keyword', 'adwords_num', 'search_results_num', 'links_num', 'html_content'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'html_content', // excluded for faster retrieving because of the heavy data it contains
    ];
}
