<template>
	<div>

	<!-- 	<img src="https://s3.envato.com/files/211352666/Screenshots/02_Dashboard.png"> -->
		
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
					<div class="hrm-img"  >
						<img style="height: 46px; width: 46px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQv6WZ-jtTctKOWxCD5u2B7b-XNfpJoxXB0THTVVsB1Yo99OrjG">
						<div class="hrm-admin-name">mishu</div>
					</div>
					<div class="hrm-img"  >
						<img style="height: 46px; width: 46px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQv6WZ-jtTctKOWxCD5u2B7b-XNfpJoxXB0THTVVsB1Yo99OrjG">
						<div class="hrm-admin-name">MD.Asaquzzaman  Faruk</div>
					</div>
					<div class="hrm-img"  >
						<img style="height: 46px; width: 46px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQv6WZ-jtTctKOWxCD5u2B7b-XNfpJoxXB0THTVVsB1Yo99OrjG">
						<div class="hrm-admin-name">Kabir</div>
					</div>
					<div class="hrm-img"  >
						<img style="height: 46px; width: 46px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQv6WZ-jtTctKOWxCD5u2B7b-XNfpJoxXB0THTVVsB1Yo99OrjG">
						<div class="hrm-admin-name">MD.Asaquzzaman mishu</div>
					</div>
					<div class="hrm-img"  >
						<img style="height: 46px; width: 46px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQv6WZ-jtTctKOWxCD5u2B7b-XNfpJoxXB0THTVVsB1Yo99OrjG">
						<div class="hrm-admin-name">MD.Asaquzzaman</div>
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
				<div class="hrm-count">{{ employees }} Employess</div>
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







		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="dashboard_activity" class="postbox ">
							<h2 class="hndle ui-sortable-handle"><span>Attendance</span></h2>
							<div class="inside">
								ljhakjsgf
								<div id="">
									<div id="" class="activity-block">
										<ul class="subsubsub">
											<li class="all">
												<a href="#l">Present<span class="count">(<span class="all-count">1</span>)</span></a> |
											</li>
											<li class="moderated">
												<a href="#">Absent<span class="count">(<span class="pending-count">0</span>)</span></a> |
											</li>
											<li class="approved">
												<a href="#">Early Enter<span class="count">(<span class="approved-count">1</span>)</span></a> |
											</li>
											<li class="spam">
												<a href="#">Early Leave<span class="count">(<span class="spam-count">0</span>)</span></a> |
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>


				
				<div id="postbox-container-2" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<div id="dashboard_quick_press" class="postbox ">
						<button type="button" class="handlediv" aria-expanded="true">
			
						<span class="toggle-indicator" aria-hidden="true"></span>
						</button>
						<h2 class="hndle ui-sortable-handle"><span><span class="hide-if-no-js">Quick Draft</span> <span class="hide-if-js">Your Recent Drafts</span></span></h2>
						<div class="inside">

						<form name="post" action="http://localhost/hrm/wp-admin/post.php" method="post" id="quick-press" class="initial-form hide-if-no-js">


						<div class="input-text-wrap" id="title-wrap">
						<label class="prompt" for="title" id="title-prompt-text">

						Title			</label>
						<input type="text" name="post_title" id="title" autocomplete="off">
						</div>

						<div class="textarea-wrap" id="description-wrap">
						<label class="prompt" for="content" id="content-prompt-text">What’s on your mind?</label>
						<textarea name="content" id="content" class="mceEditor" rows="3" cols="15" autocomplete="off"></textarea>
						</div>

						<p class="submit">		
							<input type="submit" name="save" id="save-post" class="button button-primary" value="Save Draft">			
							<br class="clear">
						</p>

						</form>
						</div>
						</div>

					</div>	
				</div>


			</div>

		</div>









	</div>
</template>

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
	    color: #e0e0e0cf;
	}

	.hrm-block-3 .hrm-count {
		padding-top: 16px;
	}
	.hrm-block-4 .hrm-count {
		padding-top: 13px;
	}
	
	.hrm-block-1 {
		background: #d5d5d5; /*#30ddbc;*/
	}
	.hrm-block-2 {
		background: #8e99a1; /*#01bcd4;*/
	}
	.hrm-block-3 {
		background: #6d7993; /*#7e57c2;*/
	}
	.hrm-block-4 {
		background: #96838d; /*#2b6a93;*/
	}
	.hrm-block {
		float: left;
		width: 25%;
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
		color: #e0e0e070;
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
	    background: rgba(197, 196, 196, 0.6);
	    width: 100%;
	    text-align: center;
	    color: #555;
	    font-weight: 600;
    	
	}

</style>

<script>

	export default {
		mixins: [HRMMixin.dashboard],

		data () {
			return {
				administrators: [],
				managers: [],
				employees: 0,
				males: 0,
				females: 0
			}
		},
		
		created () {
			var self = this;

			this.getHeaderBlock({
				callback (args) {
					self.administrators = args.administrators;
					self.managers       = args.managers;
					self.employees      = args.employees;
					self.males          = args.males;
					self.females        = args.females;
				}
			});

			this.getDashboardAttendance();
			this.getDashboardLeaves();
			this.getDashboardNotices();
			this.getDashboardBirthdays();
		},

		computed: {

		},
		components: {

		},

		methods: {

		}
	}
</script>