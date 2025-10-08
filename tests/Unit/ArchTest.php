<?php

declare(strict_types=1);

arch()->preset()->php();
// arch()->preset()->strict();
arch()->preset()->laravel();
arch()->preset()->security();
arch()->expect('App\Models')->toBeClasses()->toExtend('Illuminate\Database\Eloquent\Model');
arch()->expect('App\Controllers\Controller')->toBeAbstract();
