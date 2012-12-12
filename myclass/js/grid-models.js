/*********************** GRID MODELS ****************************************/	
	
	var coursecb = new Ext.grid.CheckboxSelectionModel();
	var courseModel = new Ext.grid.ColumnModel([coursecb,
        {id: 'courseid', 			header: "ID", 			width: 30, 	sortable: true, dataIndex: 'courseid'},
		{id: 'subject_desc',		header: "Description", 	width: 200, sortable: true, dataIndex: 'subject_desc'},
		{id: 'department_desc',		header: "Department", 	width: 200,	sortable: true, dataIndex: 'department_desc'},
        {id: 'college_desc',		header: "College", 		width: 200,	sortable: true, dataIndex: 'college_desc'},
        {id: 'course_capacity',		header: "Capacity", 	width: 90, 	sortable: true, dataIndex: 'course_capacity'},
        {id: 'course_offerings',	header: "Offerings", 	width: 90, 	sortable: true, dataIndex: 'course_offerings'},
    ]);
	
	var locationcb = new Ext.grid.CheckboxSelectionModel();
	var locationsModel = new Ext.grid.ColumnModel([locationcb,
        {id: 'locationid', 				header: "ID", 			width: 30, 		sortable: true, dataIndex: 'locationid'},
		{id: 'location_desc',			header: "Description", 	width: 200,	 	sortable: true, dataIndex: 'location_desc'},
		{id: 'college_desc',			header: "College", 		width: 200,		sortable: true, dataIndex: 'college_desc'},
        {id: 'location_department',		header: "Department", 	width: 250,		sortable: true, dataIndex: 'location_department'},
        {id: 'location_capacity',		header: "Capacity", 	width: 30, 		sortable: true, dataIndex: 'location_capacity'},
        {id: 'location_type',			header: "Type", 		width: 90, 		sortable: true, dataIndex: 'location_type'},
		{id: 'location_items',			header: "Room Items", 	width: 150, 	sortable: true, dataIndex: 'location_items'},
    ]);
	
	var timeslotscb = new Ext.grid.CheckboxSelectionModel();
	var timeslotsModel = new Ext.grid.ColumnModel([timeslotscb,
        {id: 'timeslotid', 				header: "ID", 			width: 30, 	sortable: true, dataIndex: 'timeslotid'},
		{id: 'timeslot_desc',			header: "Description", 	width: 200, sortable: true, dataIndex: 'timeslot_desc'},
		{id: 'timeslot_priority',		header: "Priority", 	width: 200,	sortable: true, dataIndex: 'timeslot_priority'},
        {id: 'timeslot_types',			header: "Types", 		width: 200,	sortable: true, dataIndex: 'timeslot_types'},
	]);
	
	var facultiescb = new Ext.grid.CheckboxSelectionModel();
	var facultiesModel = new Ext.grid.ColumnModel([facultiescb,
        {id: 'facultyid', 				header: "ID", 					width: 30, 		sortable: true, dataIndex: 'facultyid'},
		{id: 'faculty_desc',			header: "Name", 				width: 200, 	sortable: true, dataIndex: 'faculty_desc'},
		{id: 'college_desc',			header: "College", 				width: 200,		sortable: true, dataIndex: 'college_desc'},
        {id: 'faculty_maxload',			header: "Max Load", 			width: 30,		sortable: true, dataIndex: 'faculty_maxload'},
        {id: 'faculty_minload',			header: "Minload", 				width: 30, 		sortable: true, dataIndex: 'faculty_minload'},
        {id: 'faculty_preftime',		header: "Preferred Time", 		width: 100, 	sortable: true, dataIndex: 'faculty_preftime'},
		{id: 'faculty_prefloc',			header: "Preferred Location", 	width: 100, 	sortable: true, dataIndex: 'faculty_prefloc'},
		{id: 'faculty_teachables',		header: "Teachables", 			width: 400, 	sortable: true, dataIndex: 'faculty_teachables'},
    ]);
	
	var collegecb = new Ext.grid.CheckboxSelectionModel();
	var collegeModel = new Ext.grid.ColumnModel([collegecb,
        {id: 'collegeid', 		header: "ID", 			width: 30,	sortable: true, dataIndex: 'collegeid'},
		{id: 'college_code',	header: "College Code", width: 120, sortable: true, dataIndex: 'college_code'},
        {id: 'college_desc', 	header: "Description", 	width: 400, sortable: true, dataIndex: 'college_desc'},
    ]);
	
	
	var departmentscb = new Ext.grid.CheckboxSelectionModel();
	var departmentsModel = new Ext.grid.ColumnModel([departmentscb,
        {id: 'departmentid',	header: "ID",				width: 30,	sortable: true, dataIndex: 'departmentid'},
		{id: 'department_desc', header: "Description",		width: 400, sortable: true, dataIndex: 'department_desc'},
		{id: 'college_desc', 	header: "College",			width: 400, sortable: true, dataIndex: 'college_desc'},
    ]);
	
	var subjectscb = new Ext.grid.CheckboxSelectionModel();
	var subjectsModel = new Ext.grid.ColumnModel([subjectscb,
        {id: 'subjectid',		header: "ID", 				width: 30,	sortable: true, dataIndex: 'subjectid'},
		{id: 'subject_code',	header: "Code", 			width: 90, 	sortable: true, dataIndex: 'subject_code'},
		{id: 'subject_desc',	header: "Description", 		width: 250, sortable: true, dataIndex: 'subject_desc'},
		{id: 'subject_units',	header: "Units", 			width: 30, 	sortable: true, dataIndex: 'subject_units'},
		{id: 'department_desc', header: "Department", 		width: 250, sortable: true, dataIndex: 'department_desc'},
		{id: 'college_desc',	header: "College", 			width: 250, sortable: true, dataIndex: 'college_desc'},
		{id: 'typeid',			header: "Type", 			width: 200, sortable: true, dataIndex: 'typeid'},
		{id: 'room_options',	header: "Room Options", 	width: 200, sortable: true, dataIndex: 'room_options'},
		{id: 'room_items',		header: "Room Items", 		width: 200, sortable: true, dataIndex: 'room_items'},
    ]);
	
	var typescb = new Ext.grid.CheckboxSelectionModel();
	var typesModel = new Ext.grid.ColumnModel([typescb,
        {id: 'typeid',		header: "ID", 			width: 30, 	sortable: true, dataIndex: 'typeid'},
		{id: 'type_code', 	header: "Code", 		width: 90, 	sortable: true, dataIndex: 'type_code'},
		{id: 'type_desc', 	header: "Description", 	width: 400, sortable: true, dataIndex: 'type_desc'},
    ]);
	
	var itemscb = new Ext.grid.CheckboxSelectionModel();
	var itemsModel = new Ext.grid.ColumnModel([itemscb,
        {id: 'itemid', 		header: "ID", 			width: 30, 	sortable: true, dataIndex: 'itemid'},
		{id: 'item_code', 	header: "Code", 		width: 90, 	sortable: true, dataIndex: 'item_code'},
		{id: 'item_desc', 	header: "Description", 	width: 400, sortable: true, dataIndex: 'item_desc'},
    ]);
	
	var scopescb = new Ext.grid.CheckboxSelectionModel();
	var scopesModel = new Ext.grid.ColumnModel([scopescb,
        {id: 'scopeid', 	header: "ID", 			width: 30, 	sortable: true, dataIndex: 'scopeid'},
		{id: 'scope_desc', 	header: "Description", 	width: 400, sortable: true, dataIndex: 'scope_desc'},
    ]);
	
	var dayscb = new Ext.grid.CheckboxSelectionModel();
	var daysModel = new Ext.grid.ColumnModel([
		dayscb,
        {id: 'dayid', 		header: "ID", 	width: 30, 	sortable: true, dataIndex: 'dayid'},
		{id: 'day_code', 	header: "Code", width: 300, sortable: true, dataIndex: 'day_code'},
    ]);
	
	var timecb = new Ext.grid.CheckboxSelectionModel();
	var timeModel = new Ext.grid.ColumnModel([
		timecb,
        {id: 'timeid', 		header: "ID", 			width: 90, 	sortable: true, dataIndex: 'timeid'},
		{id: 'time_start', 	header: "Start", 		width: 300, sortable: true, dataIndex: 'time_start'},
		{id: 'time_end', 	header: "End", 			width: 300, sortable: true, dataIndex: 'time_end'},
    ]);
