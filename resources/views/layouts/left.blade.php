<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image" style="height: 45px; line-height: 45px;">
          <!--<img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">-->
            </div>
            <div class="pull-left info">
                <p>{{ auth('admin')->user()->username}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree"><li class="header">控制面板</li>
            <?php

            $current=array_key_exists('as',Route::current()->action)==true?(Route::current()->action)["as"]:"";
            $root=$menu->where('pid','-1');
            foreach ($root as $v)
            {
            $childs=$menu->where('pid',$v['id']);
            if (!$childs->isEmpty())
            {
                if ($current!=""&&in_array($current,array_column($childs->toArray(),"link")))
                    echo  " <li class=\"active treeview menu-open\"><a href=\"#\"><i class=\"fa fa-users\"></i> <span>".$v["name"]."</span>";
                else
                 echo  " <li class=\"treeview\"><a href=\"#\"><i class=\"fa fa-users\"></i> <span>".$v["name"]."</span>";


                 echo "<span class=\"pull-right-container\"><i class=\"fa fa-angle-left pull-right\"></i></span></a>"
                 . "  <ul class=\"treeview-menu\">";
                    foreach ($childs as  $child){
                        if ($child["link"]==null||$child["link"]=="") echo "<li><a href=\"#\"><i class=\"fa fa-circle-o\"></i>".$child["name"]."</a></li>";
                    else
                        { if($current==$child->link)
                            echo "<li class='active'><a href=\"".route($child->link)."\" style='color:#e14f1c'><i class=\"fa fa-circle-o\"></i>".$child["name"]."</a></li>";
                        else
                            echo "<li><a href=\"".route($child->link)."\"><i class=\"fa fa-circle-o\"></i>".$child["name"]."</a></li>";
                        }
                    }
                    echo "</ul></li>";
            } else
                {
                    if ($v["link"]==null||$v["link"]=="")  echo "<li><a href=\"#\"><i class=\"fa fa-circle-o text-red\"></i> <span>".$v["name"]."</span></a></li>";
                    else echo "<li><a href=\"".route($v["link"])."\"><i class=\"fa fa-circle-o text-red\"></i> <span>".$v["name"]."</span></a></li>";
                }
            }
            ?>
          <!--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span> important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

