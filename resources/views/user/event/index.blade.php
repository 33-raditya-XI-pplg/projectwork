@extends('layouts.panel.index')
@section('title', 'Event')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }

            #shadow {
                box-shadow: 0 6px 6px rgba(0, 0, 0, 0.1);
            }

            .img-container {
                position: relative;
                padding-top: 56.25%;
                /* This sets the aspect ratio to 16:9 */
            }

            .img-container img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .deskripsi {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
    @endpush

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <nav>
            <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-all"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">All</button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-draft"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Draft</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-publish"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Publish</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-live"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Berlangsung</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-end"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Selesai</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id-nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                    <td><button type="button" class="btn btn-success
                                    rounded-3" disabled>status</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editid_event"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger" data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                                <li><a href="#"
                                                        class="dropdown-item text-warning"><i class="fa-solid fa-code pe-none"></i>
                                                        Rincian</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>

                {{--  --}}
            </div>
            <div class="tab-pane fade" id="nav-draft" role="tabpanel" aria-labelledby="nav-home-tab">
                {{--  --}}

                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                    <td><button type="button" class="btn btn-outline-warning rounded-3"
                                        disabled>Draft</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>

                {{--  --}}
            </div>
            <div class="tab-pane fade" id="nav-publish" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                        <td><button type="button" class="btn btn-outline-primary rounded-3"
                                            disabled>Publish</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-live" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                        <td><button type="button" class="btn btn-outline-warning rounded-3"
                                            disabled>Berlangsung</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-end" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="mt-4">
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col ">Nama Event</th>
                            <th scope="col">Jenis Event</th>
                            <th scope="col">Tanggal Event</th>
                            <th scope="col">Tanggal Berakhir</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">

                                <tr>
                                    <td>nama_event</td>
                                    <td>jenis_event_id->nama_jenis_event</td>
                                    <td>tgl_mulai</td>
                                    <td>tgl_berakhir</td>
                                    <td>instansi_id->nama_instansi</td>
                                        <td><button type="button" class="btn btn-outline-success rounded-3"
                                            disabled>Selesai</button></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item text-info" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#edit"><i
                                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                                <li><a href="#"
                                                        class="dropdown-item text-danger"
                                                        data-confirm-delete="true"><i
                                                            class="fa-regular fa-trash-can pe-none"></i>
                                                        Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- <div class="filter-training mb-4" id="shadow">
        <div class="card border-0">
            <div class="card-header bg-primary text-white">
                <label for=""><b> Filter</b></label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="">Kategori Program Pelatihan</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Semua</option>
                            <option value="Diselenggarakan Pemerintah">Diselenggarakan Pemerintah</option>
                            <option value="Kampus UKM">Kampus UKM</option>
                            <option value="Kategori Lainnya">Kategori Lainnya</option>
                            <option value="Pendampingan UKM">Pendampingan UKM</option>
                            <option value="Sertifikasi">Sertifikasi</option>
                            <option value="Vokasional">Vokasional</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" id="date">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Jenis Event</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Semua</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                            <option value="hybrid">Hybrid</option>
                        </select>

                            <label for="">Pilih</label>
                            <select data-placeholder="Choose a Country..." class="chosen-select form-control"
                                tabindex="2">
                                <option value=""></option>
                                <option value="United States">United States</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Aland Islands">Aland Islands</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
                                <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Bouvet Island">Bouvet Island</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The
                                </option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote D&apos;ivoire">Cote D'ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curacao">Curacao</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-bissau">Guinea-bissau</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands
                                </option>
                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea, Democratic People&apos;s Republic of">Korea, Democratic People's
                                    Republic of</option>
                                <option value="Korea, Republic of">Korea, Republic of</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Lao People&apos;s Democratic Republic">Lao People's Democratic Republic
                                </option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macao">Macao</option>
                                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav
                                    Republic of</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Pitcairn">Pitcairn</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russian Federation">Russian Federation</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saint Barthelemy">Saint Barthelemy</option>
                                <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and
                                    Tristan da Cunha</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South
                                    Sandwich Islands</option>
                                <option value="South Sudan">South Sudan</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Timor-leste">Timor-leste</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands
                                </option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of
                                </option>
                                <option value="Viet Nam">Viet Nam</option>
                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                    </div>
                    <div class="col-md-2 mb-3 mt-4">
                        <button type="submit" class="btn btn-primary rounded">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                        <p class="deskripsi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita vero eum sed
                            ipsa perspiciatis repudiandae!</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('rincian-user.index') }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded"><i
                                    class="far fa-registered"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                        <p class="deskripsi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita vero eum sed
                            ipsa perspiciatis repudiandae!</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('rincian-user.index') }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded"><i
                                    class="far fa-registered"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                        <p class="deskripsi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita vero eum sed
                            ipsa perspiciatis repudiandae!</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('rincian-user.index') }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded"><i
                                    class="far fa-registered"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                        <p class="deskripsi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita vero eum sed
                            ipsa perspiciatis repudiandae!</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('rincian-user.index') }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded"><i
                                    class="far fa-registered"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                        <p class="deskripsi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita vero eum sed
                            ipsa perspiciatis repudiandae!</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('rincian-user.index') }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded"><i
                                    class="far fa-registered"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="img-container" id="shadow">
                    <img src="{{ asset('assets/img/wa.jpg') }}" alt="">
                </div>
                <div class="container">
                    <div class="text-left mt-3">
                        <h5>Mascitra.com</h5>
                        <p class="deskripsi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita vero eum sed
                            ipsa perspiciatis repudiandae!</p>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-3">
                        <div>
                            <a href="{{ route('rincian-user.index') }}"
                                class="btn btn-sm btn-warning float-end rounded"><i class="fas fa-tasks"></i> Rincian</a>
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 rounded"><i
                                    class="far fa-registered"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="register text-center mt-4 mb-4">
        <a href="#" class="btn btn-lg btn-outline-primary rounded">Daftar</a>
    </div>
@endsection
