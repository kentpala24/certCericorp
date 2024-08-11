<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Desk</a>
                    </li>
                    <li class="nav-title">
                        Digital Certificate
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Manage Batches</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Certified Lots</a>
                            </li>
                            <li class="nav-item">
                                <a @click="menu=2" class="nav-link" href="#"><i class="icon-bag"></i>
                                Lot Request</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i>Digital Certificate </a>
                        <ul class="nav-dropdown-items">
                            <li  @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Certificates</a>
                            </li>
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Generate Certificate</a>
                            </li>
                            <li @click="menu=19" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Edition Certificate</a>
                            </li>
                            <li @click="menu=18" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Generate Card </a>
                            </li>
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Digital signature</a>
                            </li>
                            <li @click="menu=14" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Designation</a>
                            </li>
                            <li @click="menu=15" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Revalidation</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i>Certificados</a>
                        <ul class="nav-dropdown-items">
                            <li  @click="menu=23" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Certificados</a>
                            </li>
                            <li @click="menu=21" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Personas</a>
                            </li>
                            <li  @click="menu=24" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Firmas</a>
                            </li>
                            <li @click="menu=22" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Designacion</a>
                            </li>
                            <li  @click="menu=25" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Edition Certificates</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i>Equipment</a>
                        <ul class="nav-dropdown-items">
                            <li  @click="menu=16" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Equipment</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i>Professional</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i>Professional</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="help/CP-IT-04_Instruction_for_Reques.pdf" target="_blank"><i class="icon-book-open"></i> Help <span class="badge badge-danger">PDF</span></a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>