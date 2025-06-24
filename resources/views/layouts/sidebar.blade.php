<div class="sidebar {{Auth::user()->openSideBar == '0' ? 'close' : ''}}">
    <div class="openclose-button">
        <i class='bx bx-chevron-right toggle'></i>
    </div>

    <ul class="nav-links">

        {{-- ============== TOP SIDE BAR ============= --}}
        <li>
        <div class="profile-details">
            <div class="profile-content">
                <img class="fotoProfil" alt="Foto Profil">
            </div>
            <div class="name-job">
            <div class="profile_name h-50">{{ Auth::user()->name }}</div>
            <div class="job">
                {{Auth::user()->role_id == 0 ? 'Guest' : ''}}
                {{Auth::user()->role_id == 1 ? 'Dokter' : ''}}
                {{Auth::user()->role_id == 2 ? 'Perawat' : ''}}
                {{Auth::user()->role_id == 3 ? 'Sekretaris P2K3' : ''}}
                {{Auth::user()->role_id == 4 ? 'Direksi' : ''}}
                {{Auth::user()->role_id == 5 ? 'Psikolog' : ''}}
                {{Auth::user()->role_id == 6 ? 'Apoteker' : ''}}
                {{Auth::user()->role_id == 7 ? 'Petugas Rekam Medis' : ''}}
            </div>
            </div>
        </div>
        </li>

        {{-- ============== MID (KOMPONEN) SIDE BAR ============= --}}

        <li class="{{Request::segment(1) == 'dashboard'? 'active' : ''}}">
            <a href="/dashboard">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/dashboard">Dashboard</a></li>
            </ul>
        </li>

        <li class="{{Request::segment(1) == 'sarana-prasarana'? 'active showMenu' : ''}}">
            <div class="iocn-link">
                <a href="/sarana-prasarana">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Sarana Prasarana</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name">Sarana Prasarana</a></li>
                <li><a style="{{Request::segment(2) == 'informasi-tata-ruang-klinik'? 'opacity: 1;' : ''}}" href="/sarana-prasarana/informasi-tata-ruang-klinik">Informasi Tata Ruang Klinik</a></li>
                <li><a style="{{Request::segment(2) == 'fasilitas-prasarana'? 'opacity: 1;' : ''}}" href="/sarana-prasarana/fasilitas-prasarana">Fasilitas Prasarana</a></li>
                <li><a style="{{Request::segment(2) == 'inventaris-peralatan'? 'opacity: 1;' : ''}}" href="/sarana-prasarana/inventaris-peralatan">Inventaris Peralatan</a></li>
                <li><a style="{{Request::segment(2) == 'izin-pendirian-dan-operasional-klinik'? 'opacity: 1;' : ''}}" href="/sarana-prasarana/izin-pendirian-dan-operasional-klinik">Izin Pendirian Dan Operasional Klinik</a></li>
                <li><a style="{{Request::segment(2) == 'standard-operasional-prosedur-klinik'? 'opacity: 1;' : ''}}" href="/sarana-prasarana/standard-operasional-prosedur-klinik">Standard Operasional Prosedur Klinik</a></li>
            </ul>
        </li>


        <li class="{{Request::segment(1) == 'smk3'? 'active showMenu' : ''}}">
            <div class="iocn-link">
                <a href="/smk3">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">SMK3</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <a style="{{Request::segment(2) == 'pemeriksaan-kesehatan-pekerja'? 'opacity: 1;' : ''}}" href="/smk3/pemeriksaan-kesehatan-pekerja">Pemeriksaan Kesehatan Pekerja</a>
                    <ul class="sub-menu2">
                        <li><a style="{{Request::segment(3) == 'pemeriksaan-kesehatan-sebelum-bekerja'? 'opacity: 1;' : ''}}" href="/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja">Pemeriksaan Kesehatan Sebelum Bekerja</a></li>
                        <li><a style="{{Request::segment(3) == 'pemeriksaan-kesehatan-berkala'? 'opacity: 1;' : ''}}" href="/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala">Pemeriksaan Kesehatan Berkala</a></li>
                        <li><a style="{{Request::segment(3) == 'pemeriksaan-kesehatan-khusus'? 'opacity: 1;' : ''}}" href="/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus">Pemeriksaan Kesehatan Khusus</a></li>
                        <li><a style="{{Request::segment(3) == 'rencana-pemeriksaan-kesehatan'? 'opacity: 1;' : ''}}" href="/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan">Rencana Pemeriksaan Kesehatan</a></li>
                        <li><a style="{{Request::segment(3) == 'pedoman-pemeriksaan-kesehatan'? 'opacity: 1;' : ''}}" href="/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan">Pedoman Pemeriksaan Kesehatan</a></li>
                    </ul>
                </li>
                <li><a style="{{Request::segment(2) == 'health-risk-assesment'? 'opacity: 1;' : ''}}" href="/smk3/health-risk-assesment">Health Risk Assesment</a></li>
                <li><a style="{{Request::segment(2) == 'laporan-pelayanan-dan-pemeriksaan-kesehatan'? 'opacity: 1;' : ''}}" href="/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan">Laporan Pelayanan dan Pemeriksaan Kesehatan</a></li>
                <li><a style="{{Request::segment(2) == 'skp-tenaga-kesehatan'? 'opacity: 1;' : ''}}" href="/smk3/skp-tenaga-kesehatan">SKP Tenaga Kesehatan</a></li>
            </ul>
        </li>


        <li class="{{Request::segment(1) == 'pelaporan-kecelakaan'? 'active showMenu' : ''}}">
            <div class="iocn-link">
                <a href="/pelaporan-kecelakaan">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Pelaporan Kecelakaan</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name">Pelaporan Kecelakaan</a></li>
                <li><a style="{{Request::segment(2) == 'laporan-kecelakaan-kerja'? 'opacity: 1;' : ''}}" href="/pelaporan-kecelakaan/laporan-kecelakaan-kerja">Laporan Kecelakaan Kerja</a></li>
                <li><a style="{{Request::segment(2) == 'laporan-analisis-kecelakaan-kerja'? 'opacity: 1;' : ''}}" href="/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja">Laporan Analisis Kecelakaan Kerja</a></li>
            </ul>
        </li>

        <li class="{{Request::segment(1) == 'manajemen-farmasi'? 'active showMenu' : ''}}">
            <div class="iocn-link">
                <a href="/manajemen-farmasi">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Manajemen Farmasi</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name">Manajemen Farmasi</a></li>
                <li><a style="{{Request::segment(2) == 'daftar-obat'? 'opacity: 1;' : ''}}" href="/manajemen-farmasi/daftar-obat">Daftar Obat</a></li>
                <li><a style="{{Request::segment(2) == 'daftar-bmhp'? 'opacity: 1;' : ''}}" href="/manajemen-farmasi/daftar-bmhp">Daftar BMHP</a></li>
                <li><a style="{{Request::segment(2) == 'pengadaan'? 'opacity: 1;' : ''}}" href="/manajemen-farmasi/pengadaan">Pengadaan</a></li>
                <li><a style="{{Request::segment(2) == 'penerimaan'? 'opacity: 1;' : ''}}" href="/manajemen-farmasi/penerimaan">Penerimaan</a></li>
                <li><a style="{{Request::segment(2) == 'pemusnahan'? 'opacity: 1;' : ''}}" href="/manajemen-farmasi/pemusnahan">Pemusnahan</a></li>
            </ul>
        </li>

        <li class="{{Request::segment(1) == 'kesehatan-mental'? 'active showMenu' : ''}}">
            <div class="iocn-link">
                <a href="/kesehatan-mental">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Kesehatan Mental</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name">Kesehatan Mental</a></li>
                <li><a style="{{Request::segment(2) == 'registrasi-kunjungan-psikolog'? 'opacity: 1;' : ''}}" href="/kesehatan-mental/registrasi-kunjungan-psikolog">Registrasi Kunjungan Psikolog</a></li>
                <li><a style="{{Request::segment(2) == 'program-promotif-kesehatan-mental'? 'opacity: 1;' : ''}}" href="/kesehatan-mental/program-promotif-kesehatan-mental">Program Promotif Kesehatan Mental</a></li>
                <li><a style="{{Request::segment(2) == 'data-kesehatan-mental'? 'opacity: 1;' : ''}}" href="/kesehatan-mental/data-kesehatan-mental">Data Kesehatan Mental</a></li>
            </ul>
        </li>

        <li class="{{Request::segment(1) == 'rekam-medis'? 'active showMenu' : ''}}">
            <div class="iocn-link">
                <a href="/rekam-medis">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Rekam Medis</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name">Rekam Medis</a></li>
                <li><a style="{{Request::segment(2) == 'registrasi-kunjungan-klinis'? 'opacity: 1;' : ''}}" href="/rekam-medis/registrasi-kunjungan-klinis">Registrasi Kunjungan Klinis</a></li>
                <li><a style="{{Request::segment(2) == 'rekam-medis-pasien'? 'opacity: 1;' : ''}}" href="/rekam-medis/rekam-medis-pasien">Rekam Medis Pasien</a></li>
                <li><a style="{{Request::segment(2) == 'statistik-kode-icd'? 'opacity: 1;' : ''}}" href="/rekam-medis/statistik-kode-icd">Statistik Kode ICD</a></li>
                <li><a style="{{Request::segment(2) == 'distribusi-rekam-medis'? 'opacity: 1;' : ''}}" href="/rekam-medis/distribusi-rekam-medis">Distribusi Rekam Medis</a></li>
                <li><a style="{{Request::segment(2) == 'analisis-rekam-medis'? 'opacity: 1;' : ''}}" href="/rekam-medis/analisis-rekam-medis">Analisis Rekam Medis</a></li>
                <li><a style="{{Request::segment(2) == 'penjaminan-mutu'? 'opacity: 1;' : ''}}" href="/rekam-medis/penjaminan-mutu">Penjaminan Mutu</a></li>
                <li><a style="{{Request::segment(2) == 'klaim-pembiayaan'? 'opacity: 1;' : ''}}" href="/rekam-medis/klaim-pembiayaan">Klaim Pembiayaan</a></li>
            </ul>
        </li>

        <li class="{{Request::segment(1) == '/pasien'? 'active' : ''}}">
            <a href="/pasien">
                <i class='bx bx-user icon'></i>
                <span class="link_name">Pasien</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="/pasien">pasien</a></li>
            </ul>
        </li>

        @if(Auth::user()->role_id == 1)
            <li class="{{Request::segment(1) == '/users'? 'active' : ''}}">
                <a href="/users">
                    <i class='bx bx-user icon'></i>
                    <span class="link_name">Users</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/users">Users</a></li>
                </ul>
            </li>
        @endif

        {{-- ============== Contoh Dropdown ============= --}}


        {{-- <li>
            <div class="iocn-link">
                <a href="/route">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Title</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name">Title</a></li>
                <li><a href="/route">Sub Title 1</a></li>
                <li><a href="/route2">Sub Title 2</a></li>
            </ul>
        </li> --}}

        {{-- ============== Contoh Standart ============= --}}


        {{--
            <li class="{{Request::segment(1) == 'route'? 'active' : ''}}">
                <a href="/route">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Page Name</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/route">Page Name</a></li>
                </ul>
            </li>
        --}}


        {{-- ============== Contoh Dengan Role ============= --}}

        {{--
        @if(Auth::user()->role == 1)
            <li class="{{Request::segment(1) == 'route'? 'active' : ''}}">
                <a href="/route">
                    <i class='bx bx-chart icon'></i>
                    <span class="link_name">Title</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="/route">Title</a></li>
                </ul>
            </li>
        @endif
        --}}

        {{-- ============== LOGOUT DAN BOTTOM SIDE BAR ================ --}}
        <li>
            <div class="sidebar-footer">
                <span class='bx bx-moon moon'></span>
                <span class="link_name">Dark mode</span>
                <ul class="sub-menu blank">
                    <li><a class="link_name">Dark Mode</a></li>
                </ul>
                <div class="toggle-switch" id="darklightButton">
                    <span class="switch"></span>
                </div>
            </div>
        </li>

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="logout-footer">
                    <i class='bx bx-log-out icon'></i>
                    <span class="link_name">Logout</span>
                    <ul class="sub-menu logout-button">Logout</ul>
                </a>
            </form>
        </li>



        {{-- ============== END LOGOUT DAN BOTTOM SIDE BAR ============== --}}
    </ul>
</div>
