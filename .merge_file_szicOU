<!--nav id="navbar navbar-inverse">
  <div id="profile">
    <div>
      <?php if ($image) { ?>
      <img src="<?php echo $image; ?>" alt="<?php echo $firstname; ?> <?php echo $lastname; ?>" title="<?php echo $username; ?>" class="img-circle" />
      <?php } else { ?>
      <i class="fa fa-opencart"></i>
      <?php } ?>
    </div>
    <div>
      <h4><?php echo $firstname; ?> <?php echo $lastname; ?></h4>
      <small><?php echo $user_group; ?></small></div>
  </div>
  <ul class="nav navbar-nav" id="menu">
    <?php foreach ($menus as $menu) { ?>
    <li class="dropdown" id="<?php echo $menu['id']; ?>">
      <?php if (isset($menu['href'])) { ?>
      <a href="<?php echo $menu['href']; ?>" ><i class="fa <?php echo $menu['icon']; ?> fw"></i> <span><?php echo $menu['name']; ?></span></a>
      <?php } else { ?>
      <a class="parent" class="dropdown-toggle" data-toggle="dropdown" ><i class="fa <?php echo $menu['icon']; ?> fw"></i> <span><?php echo $menu['name']; ?></span><span class="caret"></span></a>
      <?php } ?>
      <?php if ($menu['children']) { ?>
      <ul class="dropdown-menu">
        <?php foreach ($menu['children'] as $children_1) { ?>
        <li>
          <?php if ($children_1['href']) { ?>
          <a href="<?php echo $children_1['href']; ?>"><?php echo $children_1['name']; ?></a>
          <?php } else { ?>
          <a class="parent"><?php echo $children_1['name']; ?></a>
          <?php } ?>
          <?php if ($children_1['children']) { ?>
          <ul class="dropdown-menu">
            <?php foreach ($children_1['children'] as $children_2) { ?>
            <li>
              <?php if ($children_2['href']) { ?>
              <a href="<?php echo $children_2['href']; ?>"><?php echo $children_2['name']; ?></a>
              <?php } else { ?>
              <a class="parent"><?php echo $children_2['name']; ?></a>
              <?php } ?>
              <?php if ($children_2['children']) { ?>
              <ul class="dropdown-menu">
                <?php foreach ($children_2['children'] as $children_3) { ?>
                <li><a href="<?php echo $children_3['href']; ?>"><?php echo $children_3['name']; ?></a></li>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
      <?php } ?>
    </li>
    <?php } ?>

                <?php if (isset($journal2) && $journal2): ?>
                <li id="journal2-menu"><a class="parent" href="<?php echo $journal2; ?>"><img class="fa fw" style="margin-left: 4px; padding-right: 6px; margin-top:-3px;" src="view/journal2/css/icons/j.png" alt=""/><span>Journal</span></a>
                    <ul>
                        <li><a href="<?php echo $journal2; ?>">Dashboard</a></li>
                        <li><a href="<?php echo $journal2_clear_cache; ?>">Clear Cache</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            
  </ul>
  <div id="stats">
    <ul>
      <li>
        <div><?php echo $text_complete_status; ?> <span class="pull-right"><?php echo $complete_status; ?>%</span></div>
        <div class="progress">
          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $complete_status; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $complete_status; ?>%"> <span class="sr-only"><?php echo $complete_status; ?>%</span></div>
        </div>
      </li>
      <li>
        <div><?php echo $text_processing_status; ?> <span class="pull-right"><?php echo $processing_status; ?>%</span></div>
        <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $processing_status; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $processing_status; ?>%"> <span class="sr-only"><?php echo $processing_status; ?>%</span></div>
        </div>
      </li>
      <li>
        <div><?php echo $text_other_status; ?> <span class="pull-right"><?php echo $other_status; ?>%</span></div>
        <div class="progress">
          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $other_status; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $other_status; ?>%"> <span class="sr-only"><?php echo $other_status; ?>%</span></div>
        </div>
      </li>
    </ul>
  </div>
</nav-->
<div class="navbar navbar-inverse" style="border-radius: 0px !important;">
  <div class="container-fluid">
    <!--div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div-->
    <!--ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul-->
   <!-- <ul class="nav navbar-nav">
      <?php foreach ($menus as $menu) { ?>
      <li class="dropdown" id="<?php echo $menu['id']; ?>">
        <?php if (isset($menu['href'])) { ?>
        <a href="<?php echo $menu['href']; ?>" ><?php echo $menu['name']; ?></a>
        <?php } else { ?>
        <a class="parent" class="dropdown-toggle" data-toggle="dropdown" ><?php echo $menu['name']; ?><i class="caret"></i></a>
        <?php } ?>
        <?php if ($menu['children']) { ?>
        
        <ul class="dropdown-menu dropdown1">
          <?php foreach ($menu['children'] as $children_1) { ?>
          <li>
            <?php if ($children_1['href']) { ?>
            <a href="<?php echo $children_1['href']; ?>"><?php echo $children_1['name']; ?></a>
            <?php } else { ?>
            <a class="parent"><?php echo $children_1['name']; ?></a>
            <?php } ?>
            <?php if ($children_1['children']) { ?>
            <ul class="dropdown-menu dropdown2">
              <?php foreach ($children_1['children'] as $children_2) { ?>
              <li>
                <?php if ($children_2['href']) { ?>
                <a href="<?php echo $children_2['href']; ?>"><?php echo $children_2['name']; ?></a>
                <?php } else { ?>
                <a class="parent"><?php echo $children_2['name']; ?></a>
                <?php } ?>
                <?php if ($children_2['children']) { ?>
                <ul class="dropdown-menu dropdown3">
                  <?php foreach ($children_2['children'] as $children_3) { ?>
                  <li><a href="<?php echo $children_3['href']; ?>"><?php echo $children_3['name']; ?></a></li>
                  <?php } ?>
                </ul>
                <?php } ?>
              </li>
              <?php } ?>
            </ul>
            <?php } ?>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
      </li>
      <?php } ?>
    </ul>-->
    
    <ul class="nav navbar-nav">
    <?php foreach ($menuitems as $menuitem) { ?>
    	<?php if(in_array($menuitem['menu_id'], $Cmenuitems)) { ?>
        	<li class="dropdown" id="<?php echo $menuitem['title']; ?>">
              <?php if ($menuitem['link']) { ?>
              <a href="<?php echo $base; ?><?php echo $menuitem['link']; ?><?php echo $token; ?>"><span><?php echo $menuitem['title']; ?></span></a>
              <?php } else { ?>
              <a class="parent" class="dropdown-toggle" data-toggle="dropdown"> <span><?php echo $menuitem['title']; ?></span><i class="caret"></i></a>
              <?php } ?>
              <?php if ($menuitem['children']) { ?>
              <ul class="dropdown-menu dropdown1">
                <?php foreach ($menuitem['children'] as $children_1) { ?>
                	<?php if(in_array($children_1['menu_id'], $Cmenuitems)) { ?>
                    	<li>
                          <?php if ($children_1['link']) { ?>
                          <a href="<?php echo $base; ?><?php echo $children_1['link']; ?><?php echo $token; ?>"><?php echo $children_1['title']; ?></a>
                          <?php } else { ?>
                          <a class="parent"><?php echo $children_1['title']; ?></a>
                          <?php } ?>
                          <?php if (isset($children_1['children']) && is_array($children_1['children'])) { ?>
                          <ul class="dropdown-menu dropdown2">
                            <?php foreach ($children_1['children'] as $children_2) { ?>
                           	 	<?php if(in_array($children_2['menu_id'], $Cmenuitems)) { ?>
                                	<li>
                                      <?php if ($children_2['link']) { ?>
                                      <a href="<?php echo $base; ?><?php echo $children_2['link']; ?><?php echo $token; ?>"><?php echo $children_2['title']; ?></a>
                                      <?php } else { ?>
                                      <a class="parent"><?php echo $children_2['title']; ?></a>
                                      <?php } ?>
                                      <?php if (isset($children_2['children']) && is_array($children_2['children'])) { ?>
                                      <ul class="dropdown-menu dropdown3">
                                        <?php foreach ($children_2['children'] as $children_3) { ?>
                                        	<?php if(in_array($children_3['menu_id'], $Cmenuitems)) { ?>
                                            	<li><a href="<?php echo $base; ?><?php echo $children_3['link']; ?><?php echo $token; ?>"><?php echo $children_3['title']; ?></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                      </ul>
                                      <?php } ?>
                                    </li>
                            	<?php } ?>
                            <?php } ?>
                          </ul>
                          <?php } ?>
                        </li>
                	<?php } ?>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
    	<?php } ?>
    <?php } ?>
  </ul>
    
  </div>
</div>
<style>
.navbar ul li:hover ul.dropdown1 { display: block; }
.navbar ul li ul.dropdown1 li:hover ul.dropdown2 { display: block; }
.navbar ul li ul.dropdown1 li ul.dropdown2 li:hover ul.dropdown3{ display: block; }
.dropdown-menu li ul.dropdown {display: none;}
.dropdown2{left: 100%;
    position: absolute;
    top: auto;
    display:none;
    margin-top: -25px;}
.dropdown3{left: 100%;
position: absolute;
top: auto;
display:none;
margin-top: -25px;}
</style>