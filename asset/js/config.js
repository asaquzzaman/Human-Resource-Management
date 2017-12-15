const HRM_Routers = [];
const HRM_Components = [];

const HRMMixin = {};
const HRMProMixin = {};
const HRMChildrenRouter = {};
const HRMModules = [];
const HRMProModules = [];

function HRMRegisterChildrenRoute (parentRouteName, routes) {
	routes.forEach(function(route) {
		if (HRMChildrenRouter.hasOwnProperty(parentRouteName)  ) {
			HRMChildrenRouter[parentRouteName].push(route);
		} else {
			HRMChildrenRouter[parentRouteName] = [route];
		}
	});
};

function HRMGetRegisterChildrenRoute(parentRouteName, prevRoute) {
	var prevRoute = prevRoute || [];

	if (HRMChildrenRouter.hasOwnProperty(parentRouteName)  ) {
		return prevRoute.concat(HRMChildrenRouter[parentRouteName]);
	}
	
	return prevRoute;
}

function HRMRegisterModule(module, path) {
	HRMModules.push(
		{
			'name': module,
			'path': path
		}
	);
}

function HRMProRegisterModule(module, path) {
	HRMProModules.push(
		{
			'name': module,
			'path': path
		}
	);
}

function hrm_user_can(cap) {
	// user_id = user_id || false;

	// if ( 
	// 	user_id 
	// 	&& 
	// 	HRM_Vars.current_user.ID != user_id
	// ) {

	// 	wp.ajax.send('hrm_user_can', {
	// 		data: {
	// 			_wpnonce: HRM_Vars.nonce,
	// 			user_id: user_id,
	// 			cap: cap
	// 		},

	// 		success (res) {
	// 			console.log(res);
	// 		}
	// 	});

	// } 
	if( 
		HRM_Vars.current_user.allcaps.hasOwnProperty(cap) 
		&&
		HRM_Vars.current_user.allcaps[cap]
	) {
		return true;
	}

	return false;
}

