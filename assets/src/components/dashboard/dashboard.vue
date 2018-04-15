<template>
	<div>
		<div id="hrm-header-loading">
			<div v-if="isFetchHeaderAllData">
				<div id="hrm-dashboard-heder-block">
					
					<div class="hrm-block hrm-block-1">
						<div class="hrm-block-content-wrap">
							<!-- <i class="far fa-user-circle"></i> -->
							
							<div class="hrm-block-image-wrap">
								<div class="hrm-img" v-if="administrators.length" v-for="administrator in administrators">
									<img :src="administrator.data.avatar" style="height: 46px; width: 46px;">
									<div class="hrm-admin-name">{{ administrator.data.display_name }}</div>
								</div>
							</div>

							<div class="hrm-clear"></div>
						</div>

						<footer>
							<div>Administrators</div>
						</footer>
					</div>
					<div class="hrm-block hrm-block-2">
						<div class="hrm-block-content-wrap">
							<!-- <i class="fas fa-users"></i> -->
							
							<div class="hrm-block-image-wrap">
								<div class="hrm-img" v-if="managers.length" v-for="manager in managers">
									<img :src="manager.data.avatar" style="height: 46px; width: 46px;">
									<div class="hrm-admin-name">{{ manager.data.display_name }}</div>
								</div>
								<div v-if="!managers.length">
									<div class="hrm-admin-name"><strong>No manager found!</strong></div>
								</div>
							</div>

							<div class="hrm-clear"></div>
						</div>

						<footer>
							<div>Managers</div>
						</footer>
					</div>
					<div class="hrm-block hrm-block-3">
						<div class="hrm-block-content-wrap">
							<i class="far fa-user"></i>
							<div class="hrm-count"><span>{{ employees }}</span> Employess</div>
							<div class="hrm-clear"></div>
						</div>
						<footer>
							<div>Employees</div>
						</footer>
					</div>
					<div class="hrm-block hrm-block-4">
						<div class="hrm-block-content-wrap">
							<i class="fas fa-transgender"></i>
							<div class="hrm-count">
								<div>{{ males }} Males</div>
								<div>{{ females }} Females</div>
								<div class="hrm-clear"></div>
							</div>
						</div>
						<footer>
							<div>Male/Female</div>
						</footer>
					</div>
					<div class="hrm-clear"></div>
					
				</div>

				<div id="dashboard-widgets-wrap">
					<div id="dashboard-widgets" class="metabox-holder">
						

						<div id="postbox-container-1" class="postbox-container">
							<div class="meta-box-sortables ui-sortable">
								

								<div id="dashboard_activity" class="postbox ">
									<h2 class="hndle ui-sortable-handle">
										<span>{{ attendanceLabel }}</span>
									</h2>
									<div class="inside">
										<div class="pm-present-body">
											<div v-if="attendance.present">
												<ul v-for="punchIn in present" class="hrm-attendance-ul">
													<li>
														<img class="hrm-dashboard-avatar" :src="punchIn.avatar_url">
														{{ punchIn.display_name }}
													</li>
													<li>{{ punchIn.punch_in_time }}</li>
												</ul>

												<div class="pm-attendance-nothing-found" v-if="!present.length">Nothing found</div>
											</div>
											
											<div v-if="attendance.absent">
												<ul v-for="punchOut in absent" class="hrm-attendance-ul">
													<li>
														<img class="hrm-dashboard-avatar" :src="punchOut.avatar_url">
														{{ punchOut.display_name }}
													</li>
													<li>No Time Available</li>
												</ul>
												<div class="pm-attendance-nothing-found" v-if="!absent.length">Nothing found</div>
											</div>
											
											<div v-if="attendance.earlyEnter">
												<ul v-for="firstEntry in earlyEnter" class="hrm-attendance-ul">
													<li>
														<img class="hrm-dashboard-avatar" :src="firstEntry.avatar_url">
														{{ firstEntry.display_name }}
													</li>
													<li>{{ firstEntry.punch_in_time }}</li>
												</ul>
												<div class="pm-attendance-nothing-found" v-if="!earlyEnter.length">Nothing found</div>
											</div>
											
											<div v-if="attendance.earlyLeave">
												<ul v-for="firstLeave in earlyLeave" class="hrm-attendance-ul">
													<li>
														<img class="hrm-dashboard-avatar" :src="firstLeave.avatar_url">
														{{ firstLeave.display_name }}
													</li>
													<li>{{ firstLeave.punch_out_time }}</li>
												</ul>
												<div class="pm-attendance-nothing-found" v-if="!earlyLeave.length">Nothing found</div>
											</div>
											
											<div v-if="attendance.lateLeave">
												<ul v-for="firstOut in lateLeave" class="hrm-attendance-ul">
													<li>
														<img class="hrm-dashboard-avatar" :src="firstOut.avatar_url">
														{{ firstOut.display_name }}
													</li>
													<li>{{ firstOut.punch_out_time }}</li>
												</ul>
												<div class="pm-attendance-nothing-found" v-if="!lateLeave.length">Nothing found</div>
											</div>
										</div>

										<div id="">
											<div id="" class="activity-block">
												<ul class="subsubsub">
													<li class="all">
														<a @click.prevent="attendanceTab('present')" href="#l">Present<span class="count">(<span class="all-count">{{ present.length }}</span>)</span></a> |
													</li>
													<li class="moderated">
														<a @click.prevent="attendanceTab('absent')" href="#">Absent<span class="count">(<span class="pending-count">{{ absent.length }}</span>)</span></a> |
													</li>
													<li class="approved">
														<a @click.prevent="attendanceTab('earlyEnter')" href="#">Early Enter<span class="count">(<span class="approved-count">{{ earlyEnter.length }}</span>)</span></a> |
													</li>
													<li class="spam">
														<a @click.prevent="attendanceTab('earlyLeave')" href="#">Early Leave<span class="count">(<span class="spam-count">{{ earlyLeave.length }}</span>)</span></a> |
													</li>
													<li class="spam">
														<a @click.prevent="attendanceTab('lateLeave')" href="#">Late Leave<span class="count">(<span class="spam-count">{{ lateLeave.length }}</span>)</span></a> 
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>



								<div class="postbox ">
									<h2 class="hndle ui-sortable-handle">
										<span class="">Birthday</span> 
									</h2>
									<div class="inside">
										<div class="pm-birthday-body">
											<ul v-for="birth in birthday" class="hrm-attendance-ul">
												<li>
													<img class="hrm-dashboard-avatar" :src="birth.data.avatar_url">
													{{ birth.data.display_name }}
												</li>
												<li>{{ birth.data.birthday }}</li>
											</ul>
											<div class="pm-birthday-nothing-found" v-if="!birthday.length">Nothing found</div>
										</div>
									</div>
								</div>


							</div>	
						</div>


						
						<div id="postbox-container-2" class="postbox-container">
							<div  class="meta-box-sortables ui-sortable">
								

								<div class="postbox ">
									<h2 class="hndle ui-sortable-handle hrm-leave-h2">
										<span class="">Leave</span> 
										<span class="">Type</span> 
										<div class="hrm-clear"></div>
									</h2>
									<div class="inside">
										<div class="pm-leave-body">
											<ul v-for="leave in leaves" class="hrm-attendance-ul">
												
												<li>
													<img class="hrm-dashboard-avatar" :src="leave.employee.data.avatar_url">
													{{ leave.employee.data.display_name }}
												</li>
												<li>{{ leave.leave_type.data.name }}</li>
											</ul>
											<div class="pm-leave-nothing-found" v-if="!leaves.length">Nothing found</div>
										</div>
									</div>
								</div>

								<div class="postbox ">
									<h2 class="hndle ui-sortable-handle">
										<span class="">Notice Board</span> 
									</h2>
									<div class="inside">
										<div class="pm-notice-body">
											
											<ul v-if="notices.length" class="hrm-notice-ul">
												<li v-for="notice in notices">
													<a @click.prevent="popUpNotice(notice)" href="#">{{ notice.title }}</a>
													<span><i class="far fa-calendar-alt"></i>{{ notice.date }}</span>
													<div v-if="notice.popup">
														<div v-hrm-dialog :title="notice.title">
															<p class="hrm-popup-date"><i class="far fa-calendar-alt"></i>{{ notice.date }}</p>
															<p v-html="notice.description"></p> 
														</div>
													</div>
												</li>
												
											</ul>
											<div class="pm-notice-nothing-found" v-if="!notices.length">Nothing found</div>
										</div>
									</div>
								</div>

							</div>	
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>



<script>
	import Directive from './directive'
	import Mixin from './mixin'

	export default {
		mixins: [Mixin],

		data () {
			return {
				administrators: [],
				managers: [],
				employees: 0,
				males: 0,
				females: 0,
				present: [],
				absent: [],
				earlyEnter: [],
				earlyLeave: [],
				lateLeave: [],
				attendanceLabel: 'Present',
				attendance: {
					present: true,
					absent: false,
					earlyEnter: false,
					earlyLeave: false,
					lateLeave: false
				},
				leaves: [],
				birthday: [],
				notices: [],
				isFetchHeaderAllData: false,
				loadingEvents: {
					headerBlock: false,
					headerAttendance: false,
					headerLeaves: false,
					headerNotice: false,
					headerBirthdays: false,
				}
			}
		},
		
		created () {
			var self = this;
			self.loadingStart('hrm-header-loading'); 
			
			this.getHeaderBlock({
				callback (args) {
					self.administrators = args.administrators;
					self.managers       = args.managers;
					self.employees      = args.employees;
					self.males          = args.males;
					self.females        = args.females;
					self.loadingEvents.headerBlock = true;
					self.checkAllLoad();
				}
			});


			this.getDashboardAttendance({
				callback (res) {
					self.present = res.present;
					self.absent = res.absent;
					self.earlyEnter = res.early_enter;
					self.earlyLeave = res.early_leave;
					self.lateLeave = res.late_leave;
					self.loadingEvents.headerAttendance = true;
					self.checkAllLoad();
				}
			});
			this.getDashboardLeaves({
				callback (res) {
					self.leaves = res;
					self.loadingEvents.headerLeaves = true;
					self.checkAllLoad();
				}
			});
			this.getDashboardNotices({
				callback (res) {
					res.data.forEach(function(notice) {
						notice.popup = false;
					});
					self.notices = res.data;
					self.loadingEvents.headerNotice = true;
					self.checkAllLoad();
				}
			});
			this.getDashboardBirthdays({
				callback (res) {
					self.birthday = res;
					self.loadingEvents.headerBirthdays = true;
					self.checkAllLoad();
				}
			});
		},

		computed: {

		},
		components: {

		},

		methods: {
			attendanceTab (section) {
				var self = this;
				
				jQuery.each(this.attendance, function(key, val) {
					self.attendance[key] = false;
				});

				this.attendance[section] = true;

				switch(section) {
					case 'present':
						self.attendanceLabel = 'Present';
						break;
					case 'absent':
						self.attendanceLabel = 'Absent';
						break;
					case 'earlyEnter':
						self.attendanceLabel = 'Early Enter';
						break;
					case 'earlyLeave':
						self.attendanceLabel = 'Early Leave';
						break;
					case 'lateLeave':
						self.attendanceLabel = 'Late Leave';
						break;
				}
			},

			popUpNotice (notice) {
				notice.popup = true;
			},
			checkAllLoad () {
				var status = true;
				jQuery.each(this.loadingEvents, function(key, load) {
					if (load === false) {
						status = false;
						return;
					}
				});

				if( status ) {
					this.isFetchHeaderAllData = true;
					this.loadingStop('hrm-header-loading');
				}
 			},
		}
	}
</script>

<style type="text/css">
	.fa-transgender,
	.fa-user {
		float: left;
		padding-left: 25px;
	}
	.hrm-count {
		float: right;
	    padding-right: 44px;
	    font-size: 14px;
	}

	.hrm-block-3 .hrm-count {
		padding-top: 16px;
	}
	.hrm-block-4 .hrm-count {
		padding-top: 13px;
	}
	
	.hrm-block-1 {
		background: #f7f7f7; /*#30ddbc;*/
	}
	.hrm-block-2 {
		background: #f7f7f7; /*#01bcd4;*/
	}
	.hrm-block-3 {
		background: #f7f7f7; /*#7e57c2;*/
	}
	.hrm-block-4 {
		background: #f7f7f7; /*#2b6a93;*/
		border-right: 1px solid #ddd;
	}
	.hrm-block {
		float: left;
		width: 24.8%;
		border-left: 1px solid #ddd;
		border-top: 1px solid #dddddd8f;
	}
	.hrm-block-content-wrap {
		height: 120px;
	}
	.hrm-block-3 .hrm-block-content-wrap,
	.hrm-block-4 .hrm-block-content-wrap {
		padding-top: 16px;
	}
	.hrm-block-image-wrap {
		height: 86px;
	    overflow-x: hidden;
	    overflow-y: scroll;
	    text-align: center;
	    padding-top: 16px;
	}
	.hrm-block-image-wrap img {
		border-radius: 25px;
		display: block;
		margin: auto;
	}
	.hrm-block-1 .fa-user-circle {
		color: #55555569;
	}
	.hrm-block-2 .fa-users {
		color: #ffffff63;
	}
	.hrm-block-3 .fa-user,
	.hrm-block-4 .fa-transgender {
		color: #a0a5aa;
	}
	.hrm-img {
		height: 90px;
	}
	.hrm-admin-name {
		line-height: 30px;
	}
	.hrm-block-1 .fa-user-circle,
	.hrm-block-2 .fa-users,
	.hrm-block-3 .fa-user,
	.hrm-block-4 .fa-transgender {
		/*margin-left: 7%;
	    margin-top: 5%;*/
	    font-size: 46px;
	}
	.hrm-block-1,
	.hrm-block-2,
	.hrm-block-3,
	.hrm-block-4 {
		position: relative;
		height: 120px;
	}
	.hrm-block-1 footer,
	.hrm-block-2 footer,
	.hrm-block-3 footer,
	.hrm-block-4 footer {
		position: absolute;
		bottom: 0;
	    background: rgba(197, 196, 196, 0.34);
	    width: 100%;
	    text-align: center;
	    color: #555;
	    font-weight: 600;
	    padding: 2px 0;
    	
	}
	.hrm-dashboard-avatar {
		height: 32px;
		width: 32px;
		/*border-radius: 100%;*/
		float: left;
		margin-right: 10px;
	}
	.hrm-dashboard-avatar:after {
		visibility: hidden;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0;
	}
	.hrm-attendance-ul li {
		display: inline-block;
	}
	.hrm-attendance-ul li:nth-child(1) {
		width: 72%;
	}

	.hrm-leave-h2 span {
		float: left;
	}
	.hrm-leave-h2 span:first-child {
		width: 72%;
	}
	#dashboard-widgets-wrap {
		margin-top: 20px;
	}
	.pm-present-body,
	.pm-birthday-body,
	.pm-leave-body,
	.pm-notice-body {
		min-height: 50px;
	}
	.pm-attendance-nothing-found {
		padding-top: 20px;
	}
	.pm-birthday-nothing-found,
	.pm-leave-nothing-found,
	.pm-notice-nothing-found {
		padding-top: 15px;
	}
	.pm-notice-body .hrm-notice-ul {
		margin: 0;
		padding: 0;
	}
	.pm-notice-body .hrm-notice-ul li {
		display: block;
		padding-top: 5px;
	}
	.hrm-notice-ul .fa-calendar-alt {
		margin-left: 10px;
		margin-right: 5px;
	}
	.hrm-popup-date {
		display: block;
		margin-left: 50%;
	}
	.hrm-popup-date .fa-calendar-alt {
		margin-right: 5px;
	}

</style>