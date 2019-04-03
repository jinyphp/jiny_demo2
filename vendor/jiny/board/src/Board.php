<?php

namespace Jiny\Board;

class Board
{
    private $db;

    private $board;
    private $bootstrap;

    public function __construct($db=null)
    {
        if($db) {
            $this->db = $db;
        } else {
            // echo __DIR__;
            // E:\test\jinydb\demo1\vendor\jiny\board\src
            $dbconf = __DIR__."\..\..\..\..\conf\\"."dbconf.php";
            $this->db = \Jiny\Database\db_init($dbconf);
        }

        $this->db->connect();
        
        $this->bootstrap = new \Jiny\Html\Bootstrap($this);
        
    }

    public function db()
    {
        return $this->db;
    }


    public function setBoard($board)
    {
        $this->board = $board;
    }



    // 목록을 출력합니다.
    public function list()
    {

        $list = "";
        if ($rows = $this->db->table($this->board)->select(['id','regdate','title'])) {

           
            $rows2 = [];
            foreach($rows as $row) {
                $row['title'] = "<a href='/board/".$row['id']."'>".$row['title']."<a>";
                $rows2 []= $row;
            }

            
            // 부트스트랩 디자인 적용
            /*
            $body = [
                'id' => "tblMain",
                'title' => $this->bootstrap->h2("Hover Rows"),
                'descript' => $this->bootstrap->p("The .table-hover class enables a hover state (grey background on mouse over) on table rows:"),
                'header' => "",
                'footer' => $this->bootstrap->butten("Add", ['type'=>"btn-primary", 'id'=>"board_new", 'align'=>"right"])
            ];
            */

            
            $body = [];
            
            $class = [
                'thead' => "thead-light"
            ];

            $list .= $this->bootstrap->tableHover($rows2, $body, $class);


            

            $num = $this->db->table($this->board)->count();
            $count = $num['count(id)'];

            $list .= "전체 수량 = ".$count;
            
            $list .= $this->pagenation($count);
          
        

        }

        // echo "Home 기본컨트롤러 실행<br>";
        return view("board",['list'=>$list]);
    }


    public function pagenation($count=0)
    {
        $pagenation = new \Jiny\Board\Pagenation($count);

        if(isset($_GET['limit'])) $limit = $_GET['limit']; else $limit = 0;
        $pagebar = $pagenation->pageArr($limit);      
        
        return $this->bootstrap->pagenation($pagebar, $limit);
    }


    

}