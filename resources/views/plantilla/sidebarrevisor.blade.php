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
                            
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i>Digital Certificate </a>
                        <ul class="nav-dropdown-items">
                            <li  @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Certificates</a>
                            </li>
                            <li  @click="menu=19" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-book-open"></i>Edition Certificates</a>
                            </li>
                            <li class="nav-item">
                                <a @click="menu=20" class="nav-link" href="#"><i class="icon-bag"></i>Edit Approval</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i>Certificados</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a @click="menu=26" class="nav-link" href="#"><i class="icon-bag"></i>Edit Approval</a>
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