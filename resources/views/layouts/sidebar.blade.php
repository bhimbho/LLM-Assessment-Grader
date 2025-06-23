<nav class="sidebar-nav">
    <ul class="nav in side-menu">
        <li class="current-page"><a href="/dashboard"><i class="list-icon feather feather-command"></i> <span class="hide-menu">Dashboard</span></a>
        </li>
        <li class="current-page"><a href="/question-bank"><i class="list-icon feather feather-file-text"></i> <span class="hide-menu">Question Bank</span></a>
        </li>
        <li class="current-page"><a href="{{ route('student-management.index') }}"><i class="list-icon feather feather-users"></i> <span class="hide-menu">Students</span></a>
        </li>
        @if(auth()->user()->role === 'admin')
        <li class="current-page"><a href="{{ route('user-management.index') }}"><i class="list-icon feather feather-user-check"></i> <span class="hide-menu">Manage Users</span></a>
        </li>
        @endif
        {{-- <li class="current-page menu-item-has-children"><a href="index.html"><i class="list-icon feather feather-command"></i> <span class="hide-menu">Dashboard</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/index.html">Default</a>
                </li>
                <li><a href="../collapsed-light/index.html">Collapsed Light</a>
                </li>
                <li><a href="../dark/index.html">Dark</a>
                </li>
                <li><a href="../horizontal-nav-icons/index.html">Horizontal Nav</a>
                </li>
                <li><a href="../rtl/index.html">RTL Demo</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children active"><a href="javascript:void(0);"><i class="list-icon feather feather-briefcase"></i> <span class="hide-menu">Apps <span class="badge bg-primary">6</span></span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/app-calender.html">Calender</a>
                </li>
                <li><a href="../default/app-chat.html">Chat</a>
                </li>
                <li><a href="../default/app-inbox.html">Inbox</a>
                </li>
                <li><a href="../default/app-contacts.html">Contacts</a>
                </li>
                <li><a href="../default/app-products.html">Products</a>
                </li>
                <li><a href="../default/app-blog.html">Blog</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-user"></i> <span class="hide-menu">Profile Pages</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/page-profile.html">Profile</a>
                </li>
                <li><a href="../default/page-login.html">Login Page</a>
                </li>
                <li><a href="../default/page-login2.html">Login Page 2</a>
                </li>
                <li><a href="../default/page-register.html">Sign Up</a>
                </li>
                <li><a href="../default/page-register2.html">Sign Up 2</a>
                </li>
                <li><a href="../default/page-register-3-step.html">3 Step Sign Up</a>
                </li>
                <li><a href="../default/page-forgot-pwd.html">Forgot Password</a>
                </li>
                <li><a href="../default/page-email-confirm.html">Confirm Email</a>
                </li>
                <li><a href="../default/page-lock-screen.html">Lock Screen</a>
                </li>
                <li><a href="../default/page-timeline.html">Timeline</a>
                </li>
                <li class="menu-item-has-children"><a href="javascript:void(0);">Error Pages</a>
                    <ul class="list-unstyled sub-menu">
                        <li><a href="../default/page-error-403.html">Error 403</a>
                        </li>
                        <li><a href="../default/page-error-404.html">Error 404</a>
                        </li>
                        <li><a href="../default/page-error-500.html">Error 500</a>
                        </li>
                        <li><a href="../default/page-error-503.html">Error 503</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-folder"></i> <span class="hide-menu">Sample Pages</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="page-blank.html">Blank Page</a>
                </li>
                <li class="menu-item-has-children"><a href="javascript:void(0);">Email Templates</a>
                    <ul class="list-unstyled sub-menu">
                        <li><a href="../default/email-templates/basic.html">Basic</a>
                        </li>
                        <li><a href="../default/email-templates/billing.html">Billing</a>
                        </li>
                        <li><a href="../default/email-templates/friend-request.html">Friend Request</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item-has-children"><a href="javascript:void(0);">Maps</a>
                    <ul class="list-unstyled sub-menu">
                        <li><a href="../default/maps-google.html">Google Maps</a>
                        </li>
                        <li><a href="../default/maps-vector.html">Vector Maps</a>
                        </li>
                    </ul>
                </li>
                <li><a href="../default/page-lightbox.html">Lightbox Popup</a>
                </li>
                <li><a href="../default/page-sitemap.html">Sitemap</a>
                </li>
                <li><a href="../default/page-search-results.html">Search Results</a>
                </li>
                <li><a href="../default/page-custom-scroll.html">Custom Scroll</a>
                </li>
                <li><a href="../default/page-utility-classes.html">Utility Classes</a>
                </li>
                <li><a href="../default/page-animations.html">Animations</a>
                </li>
                <li><a href="../default/page-faq.html">FAQ</a>
                </li>
                <li><a href="../default/page-pricing-table.html">Pricing</a>
                </li>
                <li><a href="../default/page-invoice.html">Invoice</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-feather"></i> <span class="hide-menu">UI Elements <span class="badge bg-info">7</span></span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/ui-typography.html">Typography</a>
                </li>
                <li><a href="../default/ui-buttons.html">Buttons</a>
                </li>
                <li><a href="../default/ui-cards.html">Cards</a>
                </li>
                <li><a href="../default/ui-tabs.html">Tabs</a>
                </li>
                <li><a href="../default/ui-accordions.html">Accordions</a>
                </li>
                <li><a href="../default/ui-modals.html">Modals</a>
                </li>
                <li><a href="../default/ui-icon-boxes.html">Icon Boxes</a>
                </li>
                <li><a href="../default/ui-lists.html">Lists &amp; Media Object</a>
                </li>
                <li><a href="../default/ui-grid.html">Grid</a>
                </li>
                <li><a href="../default/ui-progress.html">Progress Bars</a>
                </li>
                <li><a href="../default/ui-notifications.html">Notifications &amp; Alerts</a>
                </li>
                <li><a href="../default/ui-pagination.html">Pagination</a>
                </li>
                <li><a href="../default/ui-media.html">Media</a>
                </li>
                <li><a href="../default/ui-carousel.html">Carousel</a>
                </li>
                <li><a href="../default/ui-bootstrap.html">Bootstrap Elements</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-layout"></i> <span class="hide-menu">Forms</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/form-elements.html">Elements</a>
                </li>
                <li><a href="../default/form-material.html">Material Design</a>
                </li>
                <li><a href="../default/form-validation.html">Form Validation</a>
                </li>
                <li><a href="../default/form-dropzone.html">File Upload</a>
                </li>
                <li><a href="../default/form-pickers.html">Picker</a>
                </li>
                <li><a href="../default/form-select.html">Select and Multiselect</a>
                </li>
                <li><a href="../default/form-tags-categories.html">Tags and Categories</a>
                </li>
                <li><a href="../default/form-addons.html">Addons</a>
                </li>
                <li><a href="../default/form-editors.html">Editors</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-clipboard"></i> <span class="hide-menu">Tables</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/tables-basic.html">Basic Tables</a>
                </li>
                <li><a href="../default/tables-data-table.html">Data Table</a>
                </li>
                <li><a href="../default/tables-bootstrap.html">Bootstrap Tables</a>
                </li>
                <li><a href="../default/tables-responsive.html">Responsive Tables</a>
                </li>
                <li><a href="../default/tables-editable.html">Editable Tables</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-pie-chart"></i> <span class="hide-menu">Charts</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/charts-flot.html">Flot Charts</a>
                </li>
                <li><a href="../default/charts-morris.html">Morris Charts</a>
                </li>
                <li><a href="../default/charts-js.html">Chart-js</a>
                </li>
                <li><a href="../default/charts-sparkline.html">Sparkline Charts</a>
                </li>
                <li><a href="../default/charts-knob.html">Knob Charts</a>
                </li>
            </ul>
        </li>
        <li class="menu-item-has-children"><a href="javascript:void(0);"><i class="list-icon feather feather-heart"></i> <span class="hide-menu">Icons</span></a>
            <ul class="list-unstyled sub-menu">
                <li><a href="../default/icons-material-design.html">Material Design</a>
                </li>
                <li><a href="../default/icons-font-awesome.html">Font Awesome</a>
                </li>
                <li><a href="../default/icons-mono-social.html">Social Icons</a>
                </li>
                <li><a href="../default/icons-weather.html">Weather Icons</a>
                </li>
                <li><a href="../default/icons-linea.html">Linea Icons</a>
                </li>
                <li><a href="../default/icons-feather.html">Feather Icons</a>
                </li>
            </ul>
        </li> --}}
    </ul>
    <!-- /.side-menu -->
</nav>