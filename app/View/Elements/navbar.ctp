 
	    <div class="navbar navbar-inverse alpha black a80">
          <div class="navbar-inner container">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/i-need-this">
            	<div class='logo'>snap<span class='cursive'>happi</span></div>
<!--             	<img src='/img/beachfront/snaphappi-logo-v2.png'> -->
            </a>
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse collapse pull-right" >
              <ul class="nav">
                <li data-toggle="collapse" data-target=".nav-collapse">
                  <?php echo $this->Html->link(__('Dashboard'), 
                    array('controller' => 'workorders', 'action' => 'dashboard')
            // array('class'=>'btn btn-small')
            ); ?></li>
                <li data-toggle="collapse" data-target=".nav-collapse">
                  <?php echo $this->Html->link(__('Workorders'), 
            array('controller' => 'workorders', 'action' => 'all')
            // array('class'=>'btn btn-small')
            ); ?></li>
                <li data-toggle="collapse" data-target=".nav-collapse">
                  <?php echo $this->Html->link(__('Tasks'), 
            array('controller' => 'tasks_workorders', 'action' => 'all')
            // array('class'=>'btn btn-small')
            ); ?></li>
                <li class='promote' data-toggle="collapse" data-target=".nav-collapse">
                  <?php echo $this->Html->link(__('Activity'), 
            array('controller' => 'activity_logs', 'action' => 'all')
            // array('class'=>'btn btn-small')
            ); ?></li>
                <li class='promote' data-toggle="collapse" data-target=".nav-collapse">
                  <?php echo $this->Html->link(__('Team'), 
            array('controller' => 'editors', 'action' => 'all')
            // array('class'=>'btn btn-small')
            ); ?></li>
                <!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">More<b class="caret"></b></a>
                  <ul class="dropdown-menu pull-right alpha rgba80b">
                    <li class='hide'><a href="#">Playground</a></li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->       