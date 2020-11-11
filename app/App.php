<?php

namespace App;

use App\Traits\Common;
use App\Traits\Search;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use Search,Common;
}
