<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Search;
use App\Traits\Common;

class App extends Model
{
    use Search,Common;
}
