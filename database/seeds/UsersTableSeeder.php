<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(Faker\Generator::class);

        $avatars = [
          'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
          'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
          'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
          'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
          'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
          'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
      ];

      // 生成数据集合
       $users = factory(User::class)
                       ->times(10)
                       ->make()
                       ->each(function ($user, $index)
                           use ($faker, $avatars)
       {
           // 从头像数组中随机取出一个并赋值
           $user->avatar = $faker->randomElement($avatars);
       });

       $user_array = $users->makeVisible(['password','remember_token'])->toArray();

       User::insert($user_array);

       $user = User::find(1);
       $user->name = 'Hola';
       $user->email = 'Hola@gmail.com';
       $user->avatar = 'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
       $user->save();

       $user->assignRole('Founder');

       $user = User::find(2);
       $user->assignRole('Maintainer');

    }
}
