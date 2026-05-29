<!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">

        </div>
        <!--end::Container-->
    </div>
    <div class="app-content">

        <h5 class="mb-2">Editar HomePage Conexão</h5>
        <!--begin::Row-->
        <div class="row  g-4 mb-4">
            <div class="col-md-3 col-md-9">
                <div class="card card-outline card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Editar Temas</h3>
                        <div class="card-tools col-md-10 d-flex   align-items-center justify-content-end">

                            <div class="col-md-4">
                                <button type="button" class="card-tools btn btn-warning " data-bs-toggle="modal"
                                    data-bs-target="#criar"><i class="bi bi-plus-circle"></i> Novo Tema
                                </button>
                            </div>

                            <div>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>

                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body     ">
                        <div class="row justify-content-around p-3">
                            @foreach ($temas as $item)
                                <div class="col-12 col-md-6">
                                    <form method="POST" action="{{ route('admin.update', $item->id_tema) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="card  p-2 my-3 ">
                                            <div class="mb-3 col-md-12">
                                                <div>
                                                    <div class="mb-3">
                                                        <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}"
                                                            alt="{{ $item->titulo_tema }}">
                                                         

                                                        <input class="form-control  form-control-sm mt-3" id="foto_tema"
                                                            name="foto_tema" type="file"
                                                            accept="image/png,image/jpeg,image/webp">
                                                        <div id="emailHelp" class="form-text">Escolha a foto do Tema.
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="titulo_tema" class="form-label">Titulo Tema</label>
                                                <input type="text" class="form-control" id="titulo_tema"
                                                    name="titulo_tema" value="{{ $item->titulo_tema }}">
                                            </div>
                                            <div class="mb-3 col-md-12">
                                                <label for="subtitulo_tema" class="form-label">Subtitulo Tema</label>
                                                <textarea type="textarea" class="form-control" id="subtitulo_tema" name="subtitulo_tema" rows="5">{{ $item->subtitulo_tema }}</textarea>
                                            </div>
                                            <div class="mb-3 col-md-12">
                                                <label for="breve_descricao_tema" class="form-label">Breve Descrição
                                                    Tema</label>
                                                <input type="text" class="form-control" id="breve_descricao_tema"
                                                    name="breve_descricao_tema"
                                                    value="{{ $item->breve_descricao_tema }}">
                                            </div>
                                            <div class="col-md-6 mb-3   ">
                                                <label for="status_tema" class="form-label">Status</label>
                                                <select class="form-select form-select" aria-label="Status" required
                                                    name="status_tema" id="status_tema">
                                                    <option value="ATIVO"
                                                        {{ $item->status_tema == 'ATIVO' ? 'selected' : '' }}>
                                                        Ativo</option>
                                                    <option
                                                        value="INATIVO"{{ $item->status_tema == 'INATIVO' ? 'selected' : '' }}>
                                                        Inativo</option>
                                                </select>
                                                <div id="emailHelp" class="form-text">Informe o Status do Produto.</div>
                                            </div>
                                            <div class="">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary"
                                                    id="liveToast">Confirmar</button>
@if (session('success'))

    <div class="toast-container position-fixed bottom-0 end-0 p-3">

        <div id="liveToast"
             class="toast"
             role="alert"
             aria-live="assertive"
             aria-atomic="true">

            <div class="toast-header">

                <strong class="me-auto">
                    Tema Alterado com Sucesso
                </strong>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="toast"
                        aria-label="Close">
                </button>

            </div>

            <div class="toast-body">
                {{ session('success') }}
            </div>

        </div>

    </div>

@endif

                                                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                                    <div id="liveToast" class="toast" role="alert"
                                                        aria-live="assertive" aria-atomic="true">
                                                        <div class="toast-header">
                                                            <img src="..." class="rounded me-2" alt="...">
                                                            <strong class="me-auto">Tema Alterado com Sucesso</strong>
                                                            <small>11 mins ago</small>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="toast" aria-label="Close"></button>
                                                        </div>
                                                        <div class="toast-body">
                                                            Hello, world! This is a toast message.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            {{-- <!-- /.col -->
                                <div class="col-md-3">
                                  <div class="card card-outline card-success">
                                    <div class="card-header">
                                      <h3 class="card-title">Collapsable</h3>
                                      
                                      <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                          <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                          <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                      </div>
                                      <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">The body of the card</div>
                                    <!-- /.card-body -->
                                  </div>
                                  <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-3">
            <div class="card card-outline card-warning">
              <div class="card-header">
                <h3 class="card-title">Removable</h3>
                
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">The body of the card</div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-3">
            <div class="card card-outline card-danger">
              <div class="card-header">
                <h3 class="card-title">Maximizable</h3>
                
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-lte-toggle="card-maximize">
                    <i data-lte-icon="maximize" class="bi bi-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">The body of the card</div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col --> --}}
        </div>
        <!--end::Row-->


        {{-- <!--begin::Container-->
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                  <i class="bi bi-gear-fill"></i>
                </span>
                
                <div class="info-box-content">
                  <span class="info-box-text">CPU Traffic</span>
                  <span class="info-box-number">
                    10
                    <small>%</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-danger shadow-sm">
                  <i class="bi bi-hand-thumbs-up-fill"></i>
                </span>
                
                <div class="info-box-content">
                  <span class="info-box-text">Likes</span>
                  <span class="info-box-number">41,410</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            
            <!-- fix for small devices only -->
            <!-- <div class="clearfix hidden-md-up"></div> -->
            
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                  <i class="bi bi-cart-fill"></i>
                </span>
                
                <div class="info-box-content">
                  <span class="info-box-text">Sales</span>
                  <span class="info-box-number">760</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon text-bg-warning shadow-sm">
                  <i class="bi bi-people-fill"></i>
                </span>
                
                <div class="info-box-content">
                  <span class="info-box-text">New Members</span>
                  <span class="info-box-number">2,000</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          
          <!--begin::Row-->
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title">Monthly Recap Report</h5>
            
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
              </button>
              <div class="btn-group">
                <button
                type="button"
                class="btn btn-tool dropdown-toggle"
                data-bs-toggle="dropdown"
                >
                <i class="bi bi-wrench"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" role="menu">
                <a href="#" class="dropdown-item">Action</a>
                <a href="#" class="dropdown-item">Another action</a>
                <a href="#" class="dropdown-item"> Something else here </a>
                <a class="dropdown-divider"></a>
                <a href="#" class="dropdown-item">Separated link</a>
              </div>
            </div>
            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <!--begin::Row-->
          <div class="row">
            <div class="col-md-8">
              <p class="text-center">
                <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
              </p>
              
              <div id="sales-chart"></div>
            </div>
            <!-- /.col -->
            <div class="col-md-4">
              <p class="text-center">
                <strong>Goal Completion</strong>
              </p>
              
              <div class="progress-group">
                Add Products to Cart
                <span class="float-end"><b>160</b>/200</span>
                <div class="progress progress-sm">
                  <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                </div>
              </div>
              <!-- /.progress-group -->
              
              <div class="progress-group">
                Complete Purchase
                <span class="float-end"><b>310</b>/400</span>
                <div class="progress progress-sm">
                  <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                </div>
              </div>
              
              <!-- /.progress-group -->
              <div class="progress-group">
                <span class="progress-text">Visit Premium Page</span>
                <span class="float-end"><b>480</b>/800</span>
                <div class="progress progress-sm">
                  <div class="progress-bar text-bg-success" style="width: 60%"></div>
                </div>
              </div>
              
              <!-- /.progress-group -->
              <div class="progress-group">
                Send Inquiries
                <span class="float-end"><b>250</b>/500</span>
                <div class="progress progress-sm">
                  <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                </div>
              </div>
              <!-- /.progress-group -->
            </div>
            <!-- /.col -->
          </div>
          <!--end::Row-->
        </div>
        
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
    <!--end::Row-->
    
    <!--begin::Row-->
    <div class="row">
      <!-- Start col -->
      <div class="col-md-8">
        <!--begin::Row-->
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-warning">
              <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>
                
                <div class="card-tools">
                  <span title="3 New Messages" class="badge text-bg-warning"> 3 </span>
                  <button
                  type="button"
                  class="btn btn-tool"
                  data-lte-toggle="card-collapse"
                  >
                  <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                  <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
                <button
                type="button"
                class="btn btn-tool"
                title="Contacts"
                data-lte-toggle="chat-pane"
                >
                <i class="bi bi-chat-text-fill"></i>
              </button>
              <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
              <!-- Message. Default to the start -->
              <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                  <span class="direct-chat-name float-start"> Alexander Pierce </span>
                  <span class="direct-chat-timestamp float-end"> 23 Jan 2:00 pm </span>
                </div>
                <!-- /.direct-chat-infos -->
                <img
                class="direct-chat-img"
                src="{{asset('dash/assets/img/user1-128x128.jpg')}}"
                alt="message user image"
                />
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                  Is this template really for free? That's unbelievable!
                </div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->
              
              <!-- Message to the end -->
              <div class="direct-chat-msg end">
                <div class="direct-chat-infos clearfix">
                  <span class="direct-chat-name float-end"> Sarah Bullock </span>
                  <span class="direct-chat-timestamp float-start">
                    23 Jan 2:05 pm
                  </span>
                </div>
                <!-- /.direct-chat-infos -->
                <img
                class="direct-chat-img"
                src="{{asset('dash/assets/img/user3-128x128.jpg')}}"
                alt="message user image"
                />
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">You better believe it!</div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->
              
              <!-- Message. Default to the start -->
              <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                  <span class="direct-chat-name float-start"> Alexander Pierce </span>
                  <span class="direct-chat-timestamp float-end"> 23 Jan 5:37 pm </span>
                </div>
                <!-- /.direct-chat-infos -->
                <img
                class="direct-chat-img"
                src="{{asset('dash/assets/img/user1-128x128.jpg')}}"
                alt="message user image"
                />
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                  Working with AdminLTE on a great new app! Wanna join?
                </div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->
              
              <!-- Message to the end -->
              <div class="direct-chat-msg end">
                <div class="direct-chat-infos clearfix">
                  <span class="direct-chat-name float-end"> Sarah Bullock </span>
                  <span class="direct-chat-timestamp float-start">
                    23 Jan 6:10 pm
                  </span>
                </div>
                <!-- /.direct-chat-infos -->
                <img
                class="direct-chat-img"
                src="{{asset('dash/assets/img/user3-128x128.jpg')}}"
                alt="message user image"
                />
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">I would love to.</div>
                <!-- /.direct-chat-text -->
              </div>
              <!-- /.direct-chat-msg -->
            </div>
            <!-- /.direct-chat-messages-->
            
            <!-- Contacts are loaded here -->
            <div class="direct-chat-contacts">
              <ul class="contacts-list">
                <li>
                  <a href="#">
                    <img
                    class="contacts-list-img"
                    src="{{asset('dash/assets/img/user1-128x128.jpg')}}"
                    alt="User Avatar"
                    />
                    
                    <div class="contacts-list-info">
                      <span class="contacts-list-name">
                        Count Dracula
                       
                            <small class="contacts-list-date float-end"> 2/28/2023 </small>
                          </span>
                          <span class="contacts-list-msg">
                            How have you been? I was...
                          </span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img
                          class="contacts-list-img"
                          src="{{asset('dash/assets/img/user7-128x128.jpg')}}"
                          alt="User Avatar"
                        />

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Sarah Doe
                            <small class="contacts-list-date float-end"> 2/23/2023 </small>
                          </span>
                          <span class="contacts-list-msg"> I will be waiting for... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img
                          class="contacts-list-img"
                          src="{{asset('dash/assets/img/user3-128x128.jpg')}}"
                          alt="User Avatar"
                        />

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nadia Jolie
                            <small class="contacts-list-date float-end"> 2/20/2023 </small>
                          </span>
                          <span class="contacts-list-msg"> I'll call you back at... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img
                          class="contacts-list-img"
                          src="{{asset('dash/assets/img/user5-128x128.jpg')}}"
                          alt="User Avatar"
                        />

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Nora S. Vans
                            <small class="contacts-list-date float-end"> 2/10/2023 </small>
                          </span>
                          <span class="contacts-list-msg"> Where is your new... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img
                          class="contacts-list-img"
                          src="{{asset('dash/assets/img/user6-128x128.jpg')}}"
                          alt="User Avatar"
                        />

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            John K.
                            <small class="contacts-list-date float-end"> 1/27/2023 </small>
                          </span>
                          <span class="contacts-list-msg"> Can I take a look at... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                    <li>
                      <a href="#">
                        <img
                          class="contacts-list-img"
                          src="{{asset('dash/assets/img/user8-128x128.jpg')}}"
                          alt="User Avatar"
                        />

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Kenneth M.
                            <small class="contacts-list-date float-end"> 1/4/2023 </small>
                          </span>
                          <span class="contacts-list-msg"> Never mind I found... </span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                  </ul>
                  <!-- /.contacts-list -->
                </div>
                <!-- /.direct-chat-pane -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <input
                      type="text"
                      name="message"
                      placeholder="Type Message ..."
                      class="form-control"
                    />
                    <span class="input-group-append">
                      <button type="button" class="btn btn-warning">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.direct-chat -->
          </div>
          <!-- /.col -->

          <div class="col-md-6">
            <!-- USERS LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Latest Members</h3>

                <div class="card-tools">
                  <span class="badge text-bg-danger"> 8 New Members </span>
                  <button
                    type="button"
                    class="btn btn-tool"
                    data-lte-toggle="card-collapse"
                  >
                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="row text-center m-1">
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user1-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Alexander Pierce
                    </a>
                    <div class="fs-8">Today</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user1-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Norman
                    </a>
                    <div class="fs-8">Yesterday</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user7-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Jane
                    </a>
                    <div class="fs-8">12 Jan</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user6-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      John
                    </a>
                    <div class="fs-8">12 Jan</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user2-160x160.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Alexander
                    </a>
                    <div class="fs-8">13 Jan</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user5-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Sarah
                    </a>
                    <div class="fs-8">14 Jan</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user4-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Nora
                    </a>
                    <div class="fs-8">15 Jan</div>
                  </div>
                  <div class="col-3 p-2">
                    <img
                      class="img-fluid rounded-circle"
                      src="{{asset('dash/assets/img/user3-128x128.jpg')}}"
                      alt="User Image"
                    />
                    <a
                      class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                      href="#"
                    >
                      Nadia
                    </a>
                    <div class="fs-8">15 Jan</div>
                  </div>
                </div>
                <!-- /.users-list -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer text-center">
                <a
                  href="javascript:"
                  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                  >View All Users</a
                >
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!--end::Row-->

      </div>
      <!-- /.col -->

      <div class="col-md-4">
        <!-- Info Boxes Style 2 -->
        <div class="info-box mb-3 text-bg-warning">
          <span class="info-box-icon">
            <i class="bi bi-tag-fill"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Inventory</span>
            <span class="info-box-number">5,200</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 text-bg-success">
          <span class="info-box-icon">
            <i class="bi bi-heart-fill"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Mentions</span>
            <span class="info-box-number">92,050</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 text-bg-danger">
          <span class="info-box-icon">
            <i class="bi bi-cloud-download"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Downloads</span>
            <span class="info-box-number">114,381</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        <div class="info-box mb-3 text-bg-info">
          <span class="info-box-icon">
            <i class="bi bi-chat-fill"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Direct Messages</span>
            <span class="info-box-number">163,921</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->

        <div class="card mb-4">
          <div class="card-header">
            <h3 class="card-title">Browser Usage</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
              </button>
              <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!--begin::Row-->
            <div class="row">
              <div class="col-12">
                <div id="pie-chart"></div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!-- /.card-body -->
          <div class="card-footer p-0">
            <ul class="nav nav-pills flex-column">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  United States of America
                  <span class="float-end text-danger">
                    <i class="bi bi-arrow-down fs-7"></i>
                    12%
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  India
                  <span class="float-end text-success">
                    <i class="bi bi-arrow-up fs-7"></i> 4%
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  China
                  <span class="float-end text-info">
                    <i class="bi bi-arrow-left fs-7"></i> 0%
                  </span>
                </a>
              </li>
            </ul>
          </div>
          <!-- /.footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!--end::Row-->
    </div>
    <!--end::Container--> --}}
    </div>
    <!--end::App Content-->
</main>
<!--end::App Main-->

{{-- @include('admin.modal.criar') --}}
@include('admin.modal.criar')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toastEl = document.getElementById('liveToast');

    if (toastEl) {

        const toast = new bootstrap.Toast(toastEl);

        toast.show();
    }
});
</script>
