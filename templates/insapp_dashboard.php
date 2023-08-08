<?php

global $wpdb;
$sql =  "SELECT * FROM wp_insapp_appointment";
$result = $wpdb->get_results($sql );

?>
<div class="wrap">
	<div class="container-fluid">

		<div class="row mt-5">
			<h2 class="text-dark mt-5">
				<?php _e('Liste des rendez-vous') ?>
			</h2>
		</div>

		<ul class="nav nav-pills mb-3 justify-content-end" id="pills-tab">

			<li class="nav-item">
				<button class="nav-link active" data-bs-toggle="pill" data-bs-target="#new-etd"
					type="button">Tableau</button>
			</li>

			<li class="nav-item" role="presentation">
				<button class="nav-link" data-bs-toggle="pill" data-bs-target="#list-etd"
					type="button">Calendrier</button>
			</li>

		</ul>
		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="new-etd">
				<div class="row">
					<div class="col-12">
						<!-- card -->
						<div class="card mb-4 ">
							<div class="card-header mb-5">
								<div class="row g-2">
									<div class="col-lg-6 col-md-5 d-grid d-lg-block">
										<a href="invoice-generator.html" class="btn btn-primary">
											<font style="vertical-align: inherit">
												<font style="vertical-align: inherit">+ Créer une nouvelle facture
												</font>
											</font>
										</a>
									</div>
									<div class="col-md-7 col-lg-4">
										<input type="search" class="form-control w-100"
											placeholder="Rechercher le numéro de facture, le nom du client" />
									</div>
									<div class="col-lg-2 d-flex">
										<select class="form-select">
											<option selected>
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">Statut</font>
												</font>
											</option>
											<option value="1">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">En attente</font>
												</font>
											</option>
											<option value="2">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">Refuse</font>
												</font>
											</option>
											<option value="3">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">Accepte</font>
												</font>
											</option>
										</select>
										<a href="#!" class="btn btn-danger-soft btn-icon ms-2 texttooltip"
											data-template="trashOne">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
												viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round"
												class="feather feather-trash-2 icon-xs">
												<polyline points="3 6 5 6 21 6"></polyline>
												<path
													d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
												</path>
												<line x1="10" y1="11" x2="10" y2="17"></line>
												<line x1="14" y1="11" x2="14" y2="17"></line>
											</svg>
											<div id="trashOne" class="d-none">
												<span>Delete</span>
											</div>
										</a>
									</div>
								</div>
							</div>
							<div class="card-body my-5">
								<div class="table-responsive table-card">
									<table class="table text-nowrap mb-0 table-centered">
										<thead class="table-light">
											<tr>
												<th class="pe-0">
													<div class="form-check">
														<input class="form-check-input" id="checkAll" type="checkbox"
															value="" />
														<label class="form-check-label" for="checkAll"> </label>
													</div>
												</th>
												<th class="ps-0">
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">No</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">informations du client
														</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">E-mail</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">Raison de reservation
														</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">Montant</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">Statut</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">Date de reservation</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">Heure de reservation
														</font>
													</font>
												</th>
												<th>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">Action</font>
													</font>
												</th>
											</tr>
										</thead>
										<?php foreach($result as $rdv){ 
											$custom_id = $rdv->customer_id;
											$custom = get_user_by('ID',$custom_id);
											if(esc_url( $custom->user_url ) != null) {
												$custom_url = esc_url( $custom->user_url ) ;
											}else {
												$custom_url = TLPLUGIN_URL.'/assets/images/avatar-fallback.jpg';
											}
											if($rdv->event_id == null){
												$post = get_post($rdv->service_id);
											}else{
												$post = get_post($rdv->event_id);
											}
										?>
										<tbody>
											<tr>
												<td class="pe-0">
													<div class="form-check">
														<input class="form-check-input" type="checkbox" value=""
															id="contactCheckbox2" />
														<label class="form-check-label" for="contactCheckbox2">
														</label>
													</div>
												</td>
												<td class="ps-0">
													<a href="#!">
														<font style="vertical-align: inherit">
															<font style="vertical-align: inherit">
																<?php echo '<span>#' . esc_html( $rdv->id  ).'</span>' ?>
															</font>
														</font>
													</a>
												</td>
												<td class="ps-1">
													<div class="d-flex align-items-center">
														<a href="#!"><img src="<?php echo $custom_url ?>" alt="Image"
																class="avatar avatar-sm rounded-circle" /></a>
														<div class="ms-2">
															<h5 class="mb-0">
																<a href="#!" class="text-inherit">
																	<font style="vertical-align: inherit">
																		<font style="vertical-align: inherit">
																			<?php echo '<span>' . esc_html( $custom->display_name ).'</span>' ?>
																		</font>
																	</font>
																</a>
															</h5>
														</div>
													</div>
												</td>
												<td>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">
															<?php echo '<span>' . esc_html(  $custom->user_email).'</span>' ?>
														</font>
													</font>
												</td>
												<td>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">
															<?php echo $post->post_title; ?>
														</font>
													</font>
												</td>
												<td>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">
															<?php echo '<span>' . esc_html( $rdv->cout ).' XAX</span>' ?>
														</font>
													</font>
												</td>
												<td>
													<!-- <select name="insapp_rdv" id="insapp_rdv" class="form-control">
													<option value="En attente"
														class="badge badge-warning-soft text-warning" selected>
														<span class="badge badge-warning-soft text-warning">
															<font style="vertical-align: inherit">
																<font style="vertical-align: inherit">En attente</font>
															</font>
														</span>
													</option>
													<option value="Refusé">
														<span class="badge badge-danger-soft text-danger">
															<font style="vertical-align: inherit">
																<font style="vertical-align: inherit">Refusé</font>
															</font>
														</span>
													</option>
													<option value="Accepté">
														<span class="badge badge-success-soft text-success">
															<font style="vertical-align: inherit">
																<font style="vertical-align: inherit">Accepté</font>
															</font>
														</span>
													</option>
												</select> -->
													<?php 
													echo '
														<span class="badge badge-warning-soft text-warning">
															<font style="vertical-align: inherit">
																<font style="vertical-align: inherit">' . esc_html( $rdv->statut_rdv ).'</font>
															</font>
														</span>'
												?>
												</td>
												<td>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">
															<?php echo '<span>' . esc_html( $rdv->date_rdv ).'</span>' ?>
														</font>
													</font>
												</td>

												<td>
													<font style="vertical-align: inherit">
														<font style="vertical-align: inherit">
															<?php echo '<span>' . esc_html( $rdv->heure_rdv ).'</span>' ?>
														</font>
													</font>
												</td>
												<td>
													<div>
														<div class="dropdown">
															<a class="btn btn-ghost btn-icon btn-sm rounded-circle"href="#!" role="button" data-bs-toggle="dropdown"aria-expanded="false">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"	height="24" viewBox="0 0 24 24" fill="none"	stroke="currentColor" stroke-width="2"	stroke-linecap="round" stroke-linejoin="round"	class="feather feather-more-vertical icon-xs">
																	<circle cx="12" cy="12" r="1"></circle>
																	<circle cx="12" cy="5" r="1"></circle>
																	<circle cx="12" cy="19" r="1"></circle>
																</svg>
															</a>

															<div class="dropdown-menu">
																<a class="dropdown-item d-flex align-items-center" href="#!">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24"height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye me-2 icon-xs">
																		<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
																		<circle cx="12" cy="12" r="3"></circle>
																	</svg>View
																</a>

																<a class="dropdown-item d-flex align-items-center"
																	href="#!">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24"
																		height="24" viewBox="0 0 24 24" fill="none"
																		stroke="currentColor" stroke-width="2"
																		stroke-linecap="round" stroke-linejoin="round"
																		class="feather feather-edit me-2 icon-xs">
																		<path
																			d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
																		</path>
																		<path
																			d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
																		</path>
																	</svg>Edit
																</a>

																<a class="dropdown-item d-flex align-items-center"
																	href="#!">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24"
																		height="24" viewBox="0 0 24 24" fill="none"
																		stroke="currentColor" stroke-width="2"
																		stroke-linecap="round" stroke-linejoin="round"
																		class="feather feather-download me-2 icon-xs">
																		<path
																			d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
																		</path>
																		<polyline points="7 10 12 15 17 10"></polyline>
																		<line x1="12" y1="15" x2="12" y2="3"></line>
																	</svg>Download
																</a>

																<a class="dropdown-item d-flex align-items-center"
																	href="#!">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24"
																		height="24" viewBox="0 0 24 24" fill="none"
																		stroke="currentColor" stroke-width="2"
																		stroke-linecap="round" stroke-linejoin="round"
																		class="feather feather-trash-2 me-2 icon-xs">
																		<polyline points="3 6 5 6 21 6"></polyline>
																		<path
																			d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
																		</path>
																		<line x1="10" y1="11" x2="10" y2="17"></line>
																		<line x1="14" y1="11" x2="14" y2="17"></line>
																	</svg>Delete
																</a>
															</div>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
										<?php } ?>
									</table>
								</div>
							</div>

							<div class="card-footer d-md-flex justify-content-between align-items-center mt-4">
								<span>
									<font style="vertical-align: inherit">
										<font style="vertical-align: inherit">Affichage de 1 à 8 sur 12 entrées</font>
									</font>
								</span>
								<nav class="mt-2 mt-md-0">
									<ul class="pagination mb-0">
										<li class="page-item">
											<a class="page-link" href="#!">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">Précédent</font>
												</font>
											</a>
										</li>
										<li class="page-item">
											<a class="page-link active" href="#!">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">1</font>
												</font>
											</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="#!">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">2</font>
												</font>
											</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="#!">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">3</font>
												</font>
											</a>
										</li>
										<li class="page-item">
											<a class="page-link" href="#!">
												<font style="vertical-align: inherit">
													<font style="vertical-align: inherit">Suivant</font>
												</font>
											</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="list-etd">

		</div>
	</div>
</div>