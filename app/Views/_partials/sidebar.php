 <div class="main-sidebar sidebar-style-2">
     <aside id="sidebar-wrapper">
         <div class="sidebar-brand">
             <a href="<?= base_url().ADMIN ?>/dashboard"> <img alt="image" src="<?=  base_url().IMGPATH ?>/logo.png"
                     class="header-logo" />
                     <img alt="image" src="<?=  base_url().IMGPATH ?>/sticky-logo.png"
                     class="sticky-logo" />
             </a>
         </div>
         <ul class="sidebar-menu">
             <li class="menu-header"> <?=   lang('sidebar.main.name');  ?></li>
             <li class="dropdown">
                 <a href="#" class="menu-toggle nav-link has-dropdown"><i
                         class="fas fa-trophy"></i><span> <?=   lang('sidebar.main.submenu.contest');  ?></span></a>
                 <ul class="dropdown-menu">
                     <li><a class="nav-link" href="<?= base_url().ADMIN ?>/contests"><?=   lang('sidebar.main.submenu.manage_contest');  ?></a></li>
                 </ul>
             </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        class="far fa-image"></i><span> <?=   lang('sidebar.main.submenu.banner');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/banners"><?=   lang('sidebar.main.submenu.mange_banner');  ?></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        class="fas fa-users"></i><span> <?=   lang('sidebar.main.submenu.user');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/users"><?=   lang('sidebar.main.submenu.manage_users');  ?></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        class="fas fa-users"></i><span> <?=   lang('sidebar.main.submenu.participant');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/participant"><?=   lang('sidebar.main.submenu.manage_participant');  ?></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        class="fa fa-tag fa-lg"></i><span> <?=   lang('sidebar.main.submenu.discounts');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/promocodes"><?=   lang('sidebar.main.submenu.promocode');  ?></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        class="fas fa-tools"></i><span> <?=   lang('sidebar.main.submenu.settings');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/settings/point-settings"><?=   lang('sidebar.main.submenu.point');  ?></a></li>
                </ul>
                 <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/settings/payment-settings"><?=   lang('sidebar.main.submenu.payment');  ?></a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/settings/firebase-settings"><?=   lang('sidebar.main.submenu.push_notification');  ?></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fas fa-money-bill-wave"></i><span> <?=   lang('sidebar.main.submenu.payment_list');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/payments"><?=   lang('sidebar.main.submenu.paymenttransaction');  ?></a></li>
                </ul>
                 <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/payments/point-transaction"><?=   lang('sidebar.main.submenu.point_history');  ?></a></li>
                </ul>
            </li>
             <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        class="fa fa-file"></i><span> <?=   lang('sidebar.main.submenu.cms');  ?></span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?= base_url().ADMIN ?>/cms"><?=   lang('sidebar.main.submenu.manage_cms');  ?></a></li>
                </ul>
            </li>
          
         </ul>
     </aside>
 </div>
