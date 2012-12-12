/*********************** DATA STORES ****************************************/		

	var coursesStore = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/grid-select-all-courses.php',
		root			: 'courses',
		totalProperty	: 'totalcount',
		fields			: ['courseid', 'subject_desc', 'department_desc', 'college_desc', 'course_capacity', 'room_options', 'room_items', 'faculty_credits', 'subject_offering'],
	});
	coursesStore.load({params:{start:0, limit:34}});
	
	var timeslotsStore = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/grid-select-all-timeslots.php',
		root			: 'timeslots',
		totalProperty	: 'totalcount',
		fields			: ['timeslotid', 'timeslot_desc', 'timeslot_priority', 'timeslot_types', 'timeslot_details'],
	});
	timeslotsStore.load({params:{start:0, limit:34}});
	
	var facultiesStore = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/grid-select-all-faculties.php',
		root			: 'faculties',
		totalProperty	: 'totalcount',
		fields			: ['facultyid', 'faculty_desc', 'college_desc', 'department_desc','faculty_target', 'faculty_maxload', 'faculty_minload', 'faculty_preftime', 'faculty_prefloc', 'faculty_teachables'],
	});
	facultiesStore.load({params:{start:0, limit:34}});
	
	
	var locationsStore = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/grid-select-all-locations.php',
		root			: 'locations',
		totalProperty	: 'totalcount',
		fields			: ['locationid', 'location_desc', 'college_desc', 'location_department', 'location_capacity', 'location_type', 'location_items'],
	});
	locationsStore.load({params:{start:0, limit:34}});
	
	var collegesStore = new Ext.data.JsonStore({
		autoLoad		: true,
		url				:'model/select.php?string=colleges',
		root			: 'colleges',
		remoteSort		: true,
		totalProperty	: 'totalcount',
		fields			: ['collegeid', 'college_code', 'college_desc']
    });
	collegesStore.load({params:{start:0, limit:34}});
	
	var comboCollege = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/combo-select.php?string=colleges',
		baseParams		: {cmd: 'colleges'}, 
		root			: 'colleges',
		remoteSort		: true,
		fields			: ['collegeid', 'college_code', 'college_desc']
    });
	
	var comboItems = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/combo-select.php?string=items',
		baseParams		: {cmd: 'items'}, 
		root			: 'items',
		remoteSort		: true,
		fields			: ['itemid', 'item_code', 'item_desc']
    });
	
	var comboTime = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/combo-select.php?string=time',
		baseParams		: {cmd: 'time'}, 
		root			: 'time',
		remoteSort		: true,
		fields			: ['timeid', 'time_start', 'time_end', 'time_desc']
    });
	
	var comboDays = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/combo-select.php?string=days',
		baseParams		: {cmd: 'days'}, 
		root			: 'days',
		remoteSort		: true,
		fields			: ['dayid', 'day_code']
    });
	
	var comboTimeslot = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/combo-select.php?string=timeslots',
		baseParams		: {cmd: 'timeslots'}, 
		root			: 'timeslots',
		remoteSort		: true,
		fields			: ['timeslotid', 'timeslot_desc', 'timeslot_priority', 'timeslot_types', 'timeslot_details']
    });	
	
	var comboLocation = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/combo-select.php?string=locations',
		baseParams		: {cmd: 'locations'}, 
		root			: 'locations',
		remoteSort		: true,
		fields			: ['locationid', 'location_desc', 'location_college', 'location_department', 'location_capacity', 'location_type', 'location_items']
    });	
		
	var departmentsStore = new Ext.data.JsonStore({
		id			: 'departmentstore',
		autoLoad	: true,
		url			: 'model/select-all-departments.php',
		root		: 'departments',
		fields		: ['departmentid', 'department_desc', 'college_desc', 'collegeid']
    });
	departmentsStore.load({params:{start:0, limit:34}});
	
	var subjectsStore = new Ext.data.JsonStore({
		autoLoad	: true,
		url			: 'model/select-all-subjects.php',
		root		: 'subjects',
		fields		: ['subjectid', 'subject_code', 'subject_desc', 'subject_college', 'faculty_credits', 'subject_department', 'college_desc', 'collegeid', 'department_desc', 'departmentid', 'type_desc', 'typeid', 'subject_offering']
    });
	
	
	var subjectsGridStore = new Ext.data.JsonStore({
		autoLoad		: true,
		url				: 'model/grid-select-all-subjects.php',
		root			: 'subjects',
		remoteSort		: true,
		totalProperty	: 'totalcount',
		fields			: ['subjectid', 'subject_code', 'subject_desc', 'faculty_credits', 'collegeid', 'departmentid', 'college_desc',
'collegeid','department_desc', 'departmentid', 'typeid', 'room_options', 'room_items', 'subject_offering']
    });
	subjectsGridStore.load({params:{start:0, limit:34}});

	
	var typesStore = new Ext.data.JsonStore({
		autoLoad	: true,
		url			: 'model/select-all-types.php',
		root		: 'types',
		fields		: ['typeid', 'type_code', 'type_desc']
    });
	typesStore.load({params:{start:0, limit:34}});
	
	var itemsStore = new Ext.data.JsonStore({
		autoLoad	: true,
		url			:'model/select.php?string=items',
		root		: 'items',
		fields		: ['itemid', 'item_code', 'item_desc']
    });
	itemsStore.load({params:{start:0, limit:34}});

	var scopesStore = new Ext.data.JsonStore({
		autoLoad	: true,
		url			: 'model/select.php?string=scopes',
		root		: 'scopes',
		fields		: ['scopeid', 'scope_desc']
    });
	scopesStore.load({params:{start:0, limit:34}});
	
	var daysStore = new Ext.data.JsonStore({
		autoLoad	: true,
		url			: 'model/select.php?string=days',
		root		: 'days',
		fields		: ['dayid', 'day_code']
    });
	daysStore.load({params:{start:0, limit:34}});
	
	var timeStore = new Ext.data.JsonStore({
		autoLoad	: true,
		url			: 'model/select.php?string=time',
		root		: 'time',
		fields		: ['timeid', 'time_start', 'time_end', 'time_desc']
    });
	timeStore.load({params:{start:0, limit:34}});
	
	 var myData = [
        ['2009-2010_2_1', '2009-2010', 2, 1, 1,1],
        ['2009-2010_2_2', '2009-2010', 2, 2, 1,1],
        ['2009-2010_2_3', '2009-2010', 2, 3, 1,1],
        ['2009-2010_2_4', '2009-2010', 2, 4, 1,1],
        ['2009-2010_2_5', '2009-2010', 2, 5, 1,1], 
    ];


	var schedulesStore = new Ext.data.JsonStore({
			autoLoad	: true,
			url			: 'model/grid-select-all-schedules.php',
			root		: 'schedule_details',
		    fields		: ['scheduleid', 'schedule_desc', 'schedule_schoolyear', 'schedule_semester', 'schedule_version']
		    	
	});
	schedulesStore.load({params:{start:0, limit:34}});
	//schedulesStore.loadData(myData);
	
	
