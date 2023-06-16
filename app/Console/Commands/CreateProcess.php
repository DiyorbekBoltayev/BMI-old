<?php

namespace App\Console\Commands;

use App\Models\Chat;
use App\Models\Process;
use App\Models\Theme;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class CreateProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $a=explode('_',file_get_contents(__DIR__.'/data.txt'));
        $data=[];
        foreach ($a as $item){
            $data[]=explode('!',$item);

        }
        foreach ($data as $item){
            $theme=Theme::where('student_id',$item[0])->first();
            if($theme){
                $process=Process::where('theme_id',$theme->id)->first();
                if (!$process){
                    $p=new Process();
                    $p->theme_id=$theme->id;
                    $p->save();
                }
                $is_chat_has=Chat::where('theme_id',$theme->id)->first();
                if (!$is_chat_has){
                    $chat=new Chat();
                    $chat->theme_id=$theme->id;
                    $chat->user_id=$theme->teacher_id;
                    $chat->save();
                }
            }else{
                $t=new Theme();
                $t->name=$item[4];
                $t->status='process';
                $t->percentage=$item[5];
                $t->specialty=5330500;
                $t->level='5-kurs';
                $t->semester='10-semestr';
                $t->student_id=$item[0];
                $t->student_name=$item[1];
                $t->group_name=$item[3];
                $t->teacher_id=$item[6];
                $t->save();
                $process=new Process();
                $process->theme_id=$t->id;
                $process->save();
                $chat=new Chat();
                $chat->theme_id=$t->id;
                $chat->user_id=$t->teacher_id;
                $chat->save();

            }
        }

        return CommandAlias::SUCCESS;
    }
}
