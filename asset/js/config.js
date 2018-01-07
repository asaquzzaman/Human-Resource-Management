const HRM_Routers = [];
const HRM_Components = [];
const HRM_Store = [];
const hrm = {
	'Multiselect': {}
};

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

	if( 
		HRM_Vars.current_user.allcaps.hasOwnProperty(cap) 
		&&
		HRM_Vars.current_user.allcaps[cap]
	) {
		return true;
	}

	return false;
}

