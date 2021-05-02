<div class="dropdown" id="admin-tools-menu-button">
    <button type="button" data-toggle="dropdown" class="btn btn-tool" title="Admin Information">
        <i class="glyphicon glyphicon-option-vertical"></i>
    </button>
    <div class="dropdown-menu" style="width: 566.5px;">
        <h5 class="dropdown-item"><b>Admin Information</b></h5>
        <div class="alert alert-danger no-owner hidden dropdown-item">This record has no assigned owner. You can assign an owner from the admin area.</div>
        <dl class="dl-horizontal dropdown-item">
            <dt>Owner</dt>
            <dd>
                <div class="owner-username">admin</div>
                <a class="change-owner-link" href="#"><i class="glyphicon glyphicon-user"></i> Change owner</a>
                <br>
                <a class="user-records-link" href="admin/pageViewRecords.php?memberID=admin&amp;tableName=Customers" target="_blank"><i class="glyphicon glyphicon-th"></i> Show all records of this user from "Customers" table</a>
                <br>
                <a class="user-email-link" href="admin/pageMail.php?memberID=admin" target="_blank"><i class="glyphicon glyphicon-envelope"></i> Email this user</a>
            </dd>

            <dt>Group</dt>
            <dd>
                <div class="owner-group">Admins</div>
                <a class="group-records-link" href="admin/pageViewRecords.php?groupID=2&amp;tableName=Customers" target="_blank"><i class="glyphicon glyphicon-th"></i> Show all records of this group from "Customers" table</a>
                <br>
                <a class="group-email-link" href="admin/pageMail.php?groupID=2" target="_blank"><i class="glyphicon glyphicon-envelope"></i> Email this group</a>
            </dd>

            <dt>Created</dt>
            <dd class="record-created">08/29/2020, 01:38 pm</dd>

            <dt>Last modified</dt>
            <dd class="record-last-modified">08/30/2020, 05:57 pm</dd>
        </dl>
    </div>
</div>







<li class="nav-item show">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
        <i class="fas fa-shopping-cart"></i>
        <span class="badge badge-danger navbar-badge">3</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right show">
        <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="LAT/adminlte3/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                        Brad Diesel
                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="LAT/adminlte3/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                        John Pierce
                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">I got your message bro</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="LAT/adminlte3/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                        Nora Silvester
                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">The subject goes here</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
    </div>
</li>