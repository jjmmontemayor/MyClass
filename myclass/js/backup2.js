Ext.onReady(function(){

	Ext.BLANK_IMAGE_URL = 'images/s.gif';
    Ext.QuickTips.init();

/*********************** Global Variables ****************************************/	
	var win;

/*********************** Global Functions ****************************************/	
	
	function close() 
	{ 
		win.hide();
	}
	
/*********************** Create Tab Panel ****************************************/	
	
	var mytabs = new Ext.TabPanel({	
		id			: 'mytabs',
        activeTab	: 0,
        width		: 875,
        plain		: true,
        defaults	: {autoScroll: true},
		region		: 'center',
		margins		: '2 5 5 0',
    });		
	
	
/*********************** Courses ****************************************/
	
	var coursesPaging = new Ext.PagingToolbar({
		pageSize	: 15,
		store		: coursesStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Courses {0} - {1} of {2}',
		emptyMsg	: "No Courses to display",	
	});

    var courseGrid = new Ext.grid.GridPanel({ 
		store		: coursesStore,
		stripeRows	: true,
		height		:200, 
		width		:600, 
		id			: 'courses-grid', 
		cm			: courseModel, 
		title		: 'Courses', 
		labelAlign	: 'top',
		tbar		: [new 	Ext.Toolbar.Button({
							text	: 'Add',
							iconCls	: 'add',
							width	: 50,
							handler	: show_addCourse 
							
							}),
						new Ext.Toolbar.Button({
							text	: 'Edit',
							iconCls	: 'edit',
							width	: 50,
							}), 
						new Ext.Toolbar.Button({
							text	: 'Delete',
							iconCls	: 'delete',	
							width	: 50,
							})
						],
		
		bbar		: coursesPaging,	
			
	});
	
	mytabs.add(courseGrid);
	mytabs.setActiveTab('courses-grid');
	
		
	//add course: fields
	
	var courseCollege = new Ext.form.ComboBox({
		store			: comboCollege, //direct array data
		id				: 'course-college',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'College',
		emptyText		: 'Select a College..',
		selectOnFocus	: true,
		displayField	: 'college_desc',
		valueField		: 'collegeid',
		hiddenName		: 'course_college',
		listeners		:{select	:{fn	:	function(combo, value) {
												var combodept = Ext.getCmp('course-department');        
												combodept.clearValue();
												combodept.store.filter('collegeid', combo.getValue());
									}}
						}	
	});
	
	var courseDepartment = new Ext.form.ComboBox({
		store			: departmentsStore, //direct array data
		id				: 'course-department',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'Department',
		emptyText		:'Select a Department...',
		selectOnFocus	: true,
		valueField		: 'departmentid',
		displayField	: 'department_desc',
		hiddenName		: 'course_department',
		mode			:'local',
		lastQuery		:'',
		listeners		:{select	:{fn	:	function(combo, value) {
												var combosubj = Ext.getCmp('course-subject');        
												combosubj.clearValue();
												combosubj.store.filter('departmentid', combo.getValue());
									}}
						}		
	});
	
	var courseSubject = new Ext.form.ComboBox({
		store			: subjectsStore, //direct array data
		id				: 'course-subject',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'Subject',
		emptyText		: 'Select A Subject',
		selectOnFocus	: true,
		valueField		: 'subjectid',
		displayField	: 'subject_desc',
		hiddenName		: 'course_subject',
		mode			: 'local',
		lastQuery		: '',		
	});

	var courseCapacity = new Ext.form.TextField({
		name		: 'course_capacity',
		allowBlank	: false,
		fieldLabel	: 'Capacity',
		value		: '',
		blankText	:'Enter Capacity',
		msgTarget	:'side',
		anchor		: '50%',		
	});
	
	var courseOfferings = new Ext.form.TextField({
		name		: 'course_offerings',
		allowBlank	: false,
		fieldLabel	: 'No. of Course Offerings',
		value		: '',
		blankText	: 'Enter How Many Offerings',
		msgTarget	: 'side',
		anchor		: '50%',
			
	});
	
	
	//add course: form
	
	var create_course = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createcourse',
		frame			: true,		
		bodyStyle		: 'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-course.php',		
		items			: [courseCollege, courseDepartment, courseSubject, courseCapacity, courseOfferings],
		buttons			: [{
								text	: 'Add',
								formBind: true,	
								handler	: addCourse,	
							},
							{
								text	: 'Cancel',
								handler	:	function(){
											create_course.getForm().reset();
											close();
											},
							},
							{
								text	: 'Clear',
								handler	: 	function()
											{
												create_course.getForm().reset();
											},
							},
							
							
							]

	});
	
	//add course: window
	
	function show_addCourse()
	{
		if(!win){
			win = new Ext.Window({
					title		: 'Add Course',
					layout		:'fit',
					width		:450,
			        height		:350,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_course],
			});
		}
		win.show();
	}
	
	//add time: function
	
	function addCourse()
	{

		create_course.getForm().submit(
			{
				method		:'POST', 
				waitTitle	:'Connecting', 
				waitMsg		:'Saving data...',
				success		: function(form, action) {
							   Ext.Msg.alert('Success', action.result.msg);
							   create_course.getForm().reset();
							   close();
							   window.location.reload
							},

				failure		: function(form, action) {
								Ext.Msg.alert('Failure', action.result.msg);
							}
			}
		);
	}
	
/*********************** Locations ****************************************/

	var locationsPaging = new Ext.PagingToolbar({
		pageSize	: 15,
		store		: locationsStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Locations {0} - {1} of {2}',
		emptyMsg	: "No Locations to display",	
	});

    var locationsGrid = new Ext.grid.GridPanel({ 
		store		: locationsStore,
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		id			: 'locations-grid', 
		cm			: locationsModel, 
		title		: 'Locations', 
		labelAlign	: 'top',
		tbar		: [new 	Ext.Toolbar.Button({
							text	: 'Add',
							iconCls	: 'add',
							width	: 50,
							handler	: show_addLocation,
							
							}),
						new Ext.Toolbar.Button({
							text	: 'Edit',
							iconCls	: 'edit',
							width	: 50,
							}), 
						new Ext.Toolbar.Button({
							text	: 'Delete',
							iconCls	: 'delete',	
							width	: 50,
							})
						],
		
		bbar		: locationsPaging,	
			
	});
	
	mytabs.add(locationsGrid);
	mytabs.setActiveTab('locations-grid');	
	
	//add location: fields
	
	var locationDesc = new Ext.form.TextField({
		name		: 'location_desc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		value		: '',
		blankText	:'Enter Description',
		msgTarget	:'side',

	});

	var locationCollege = new Ext.form.ComboBox({
		store			: comboCollege, //direct array data
		id				: 'location-college',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'College',
		emptyText		: 'Select a College..',
		selectOnFocus	: true,
		displayField	: 'college_desc',
		valueField		: 'collegeid',
		hiddenName		: 'location_college',
		mode			: 'remote',
		lastQuery		: '',
		queryDelay		: 0,
	
	});
		
	var locationDepartment = new Ext.ux.form.SuperBoxSelect({
		store			: departmentsStore,
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		xtype			: 'superboxselect',
		fieldLabel		: 'Department',
		id				: 'location-department',
		mode			: 'local',
		displayField	: 'department_desc',
		valueField		: 'departmentid',
		name			: 'location_department[]',
		triggerAction	: 'all',
		mode			: 'remote',
		lastQuery		:'',
		queryDelay		: 0,
	});
	
	var locationCapacity = new Ext.form.TextField({
	name		: 'location_capacity',
	allowBlank	: false,
	fieldLabel	: 'Capacity',
	value		: '',
	blankText	:'Enter Capacity',
	msgTarget	:'side',
	});

	
	var locationTypes = new Ext.ux.form.SuperBoxSelect({
		store			: typesStore,
		xtype			: 'superboxselect',
		fieldLabel		: 'Type',
		id				: 'location-type',
		mode			: 'local',
		displayField	: 'type_code',
		valueField		: 'typeid',
		name			: 'location_type[]',
		triggerAction	: 'all',
		mode			: 'remote',
		queryDelay		: 0,
	});

	
	var locationItems = new Ext.ux.form.SuperBoxSelect({
		store			: comboItems,
		xtype			: 'superboxselect',
		fieldLabel		: 'Room Items',
		allowBlank		: false,
		id				: 'location-room-items',
		mode			: 'local',
		displayField	: 'item_desc',
		valueField		: 'itemid',
		name			: 'location_items[]',
		triggerAction	: 'all',
		queryDelay		: 0,
	});	
	
	
	//add location: form
	
	var create_location = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createlocation',
		frame			: true,		
		bodyStyle		: 'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-location.php',		
		items			: [locationDesc, locationCollege, locationDepartment, locationCapacity, locationTypes, locationItems],
		buttons			: [{
								text	: 'Add',
								formBind: true,	
								handler	: addLocation,
											/* function(){
												alert(Ext.getCmp('location-room-items').getValue());
											} */
							},
							{
								text	: 'Cancel',
								handler	:	function(){
												create_location.getForm().reset();
												close();
											},
							},
							{
								text	: 'Clear',
								handler	: 	function()
											{
												create_location.getForm().reset();
											},
							},
							
							
							]

	});
	
	//add location: window
	
	function show_addLocation()
	{
		if(!win){
			win = new Ext.Window({
					title		: 'Add Location',
					layout		:'fit',
					width		:450,
			        height		:350,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_location],
			});
		}
		win.show();
	}
	
	//add time: function
	
	function addLocation()
	{

		create_location.getForm().submit(
			{
				method		:'POST', 
				waitTitle	:'Connecting', 
				waitMsg		:'Saving data...',
				success		: function(form, action) {
							   Ext.Msg.alert('Success', action.result.msg);
							   create_location.getForm().reset();
							   close();
							   window.location.reload
							},

				failure		: function(form, action) {
								Ext.Msg.alert('Failed', action.result.msg);
							}
			}
		);
	}
	
/*********************** Timeslots ****************************************/

	
	

/*********************** Colleges ****************************************/	

	var collegePaging = new Ext.PagingToolbar({
		pageSize		: 15,
		store			: collegesStore,
		displayInfo		: true,
		displayMsg		: 'Displaying Colleges {0} - {1} of {2}',
		emptyMsg		: "No Colleges to display",	
	});
	
	var collegeGrid = new Ext.grid.GridPanel({ 
		store		: collegesStore,
		stripeRows	: true,
		height		:200, 
		width		:600, 
		cm			: collegeModel,
		sm			: collegecb,
		id			: 'colleges-grid',
		title		: 'Colleges', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
							text	: 'Add',
							iconCls	: 'add',
							width	: 50,
							handler	: show_addCollege,
						}), 
						
						new Ext.Toolbar.Button({
							text	: 'Edit',
							iconCls	: 'edit',
							width	: 50,
							handler	: getCollege,
						
						}), 
						
						new Ext.Toolbar.Button({
                        text	: 'Delete',
						iconCls	: 'delete',	
						width	: 50,
						})
					],
		bbar		: collegePaging,
	
	});

	mytabs.add(collegeGrid);
	collegesStore.load({params:{start:0, limit:15}});
	
	//add college: fields
	var collegeCode = new Ext.form.TextField({
		name			: 'collegecode',
		allowBlank		: false,
		fieldLabel		: 'College Code',
		value			: '',
		blankText		: 'Enter College Code',
		msgTarget		: 'side', 
		validationEvent	: false
			
	});
	
	var collegeDesc = new Ext.form.TextField({
		name			: 'collegedesc',
		allowBlank		: false,
		fieldLabel		: 'Description',
		value			: '',
		blankText		: 'Enter Description',
		msgTarget		: 'side', 
		validationEvent	: false
	});
	
	
	//add college: form
	
	var create_college = new Ext.FormPanel({
		monitorValid	:true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createcollege',
		frame			: true,		
		bodyStyle		:'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-college.php',		
		items			: [collegeCode,collegeDesc],
		buttons			: [	{
								text	: 'Add',
								formBind: true,
								handler	: addCollege,		
							},
							{
								text	: 'Cancel',
								handler	: function(){
											create_college.getForm().reset();
											close();
										},
							}
						]
	});
	
	//add college: window
	
	function show_addCollege()
	{
		if(!win){
			win =	new Ext.Window({
					title		: 'Add College',
					layout		:'fit',
					width		:450,
					height		:350,
					closeAction	: 'hide',
					closable	: true,
					resizable	: false,
					modal		: true,
					plain		: true,  
					items		: [create_college],
			});
		}
		
		win.show();
	}
	
	//add college: function
	
	function addCollege(){

		create_college.getForm().submit(
			{
				method:'POST', 
				waitTitle:'Connecting', 
				waitMsg:'Saving data...',
				success: function(form, action) {
						   Ext.Msg.alert('Success', action.result.msg);
						   create_college.getForm().reset();
						   close();
						   window.location.reload
						},

				failure: function(form, action) {
						   Ext.Msg.alert('Failure', action.result.msg);
						}

			}
		);
	}
	
			
	//edit college: fields
		
	var ecollegeCode = new Ext.form.TextField({
		name		: 'college_code',
		allowBlank	: false,
		fieldLabel	: 'College Code',
		blankText	: 'Enter College Code',
		msgTarget	: 'side', 
	
	});

	var ecollegeDesc = new Ext.form.TextField({
		name		: 'college_desc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		blankText	: 'Enter Description',
		msgTarget	: 'side', 	
	});

	var ecollegeId = new Ext.form.TextField({
		name		: 'collegeid',
		readOnly	: true,
		fieldLabel	: 'College ID',
		blankText	: 'College ID',
	});

	var value;
		
	// edit college: form
	var edit_college = new Ext.FormPanel({
		labelWidth	: 125,
		id			: 'editcollege',
		width		: 350,
		frame		: true,		
		bodyStyle	:'padding:5px 5px 0',
		defaults	: {width: 200},		
		items		: [ecollegeId, ecollegeCode,ecollegeDesc],
		url			: 'models/edit-college.php',
		buttons		: [	{
							text: 'Add',
							handler: updateCollege,
						},
						{
							text: 'Cancel',
							handler: 	function(){
										edit_college.getForm().reset();
										close();},
						}
					]
	});
	
	//update college: function
	function updateCollege()
	{
		edit_college.getForm().submit(
			{
				method		:'POST', 
				waitTitle	:'Connecting', 
				waitMsg		:'Saving data...',
				success		:	function(form, action) {
									Ext.Msg.alert('Success', action.result.msg);
									create_college.getForm().reset();
									close();
									window.location.reload
								},

				failure		: function(form, action) {
									Ext.Msg.alert('Failure', action.result.msg);
								}

			}
		);
	}
	//edit college: window	
			
	function show_editCollege()
	{
		if(!win){
			win = new Ext.Window(
			{
				title		: 'Edit College',
				layout		: 'fit',
				width		: 450,
				height		: 350,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				plain		: true, 
				items		: [edit_college],
			});
		}
		win.show();
	}
	
	function loadForm(theid)
	{
		edit_college.getForm().load(
		{
			url		: 'models/select-college.php',
			params	: {collegeid	: theid},
					
		});
	}
			
	function getCollege()
	{
		var selected = Ext.getCmp('colleges-grid').getSelectionModel().getCount();
		
		if(selected == "1")
		{
			var id = Ext.getCmp('colleges-grid').getSelectionModel().getSelected();
			value = id.get('collegeid');
		
			loadForm(value);
			show_editCollege();
		}
		
		else
		{
			Ext.Msg.alert('Failure', 'Please Select A College');
		}
	}
	
	
	
/*********************** Departments ****************************************/	

	var departmentPaging = new Ext.PagingToolbar({
		pageSize	: 15,
		store		: departmentsStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Departments {0} - {1} of {2}',
		emptyMsg	: "No Departments to display",	
	});
	
	var departmentsGrid = new Ext.grid.GridPanel({ 
		store		: departmentsStore,
		id			: 'departments-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: departmentsModel,
		sm			: departmentscb,	
		title		: 'Departments', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
							text	: 'Add',
							iconCls	: 'add',
							width	: 50,
							handler	: show_addDepartment,
						
						}), 
						
						new Ext.Toolbar.Button({
							text	: 'Edit',
							iconCls	: 'edit',
							width	: 50,
    
						}), 
			
						new Ext.Toolbar.Button({
							text	: 'Delete',
							iconCls	: 'delete',	
							width	: 50, 
						})
					],
			
		bbar		: departmentPaging,
	});

	mytabs.add(departmentsGrid);
	
	
	// add department: fields
	
	var departmentDesc = new Ext.form.TextField({
		name		: 'department_desc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		value		: '',
		blankText	: 'Enter Department Description',
		msgTarget	: 'side', 
			
	});
	
	var departmentCollege = new Ext.form.ComboBox({
		store			: comboCollege, //direct array data
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'College',
		emptyText		: 'Select a College...',
		selectOnFocus	: true,
		displayField	: 'college_desc',
		valueField		: 'collegeid',
		hiddenName		: 'department_college',
	});
	
	//add form
	
	var create_department = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createdepartment',
		frame			: true,		
		bodyStyle		: 'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-department.php',		
		items			: [departmentDesc, departmentCollege],
		buttons			: [	{
								text	: 'Add',
								formBind: true,
								handler	: addDepartment,
							},
							{
								text	: 'Cancel',
								handler	: function(){
											create_department.getForm().reset();
											close();},
							}
						]
	});
	
	
	//add window
	
	function show_addDepartment()
	{
		if(!win)
		{
			win = new Ext.Window({
				title		: 'Add Department',
				layout		: 'fit',
				width		: 450,
				height		: 250,
				closeAction	: 'hide',
				closable  	: true,
				resizable	: false,
				modal		: true,
				plain		: true,  
				items		: [create_department],
			});
		}
		win.show();
	}
	
	function addDepartment()
	{
		create_department.getForm().submit(
		{
			method		: 'POST', 
			waitTitle	: 'Connecting', 
			waitMsg		: 'Saving data...',
			success		: 	function(form, action) 
							{
								Ext.Msg.alert('Success', action.result.msg);
								create_college.getForm().reset();
								close();
							},

			failure		: 	function(form, action) 
							{
								Ext.Msg.alert('Failure', action.result.msg);
							}

		});
	}
	
/*********************** Subjects ****************************************/	
	
	var subjectsPaging = new Ext.PagingToolbar({
		pageSize	: 15,
		store		: subjectsGridStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Subjects {0} - {1} of {2}',
		emptyMsg	: "No Subjects to display",	
	});
	
	
	
	var subjectsGrid = new Ext.grid.GridPanel({ 
		store		: subjectsGridStore,
		id			: 'subjects-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: subjectsModel,
		sm			: subjectscb,	
		title		: 'Subjects', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
                        text	: 'Add',
						iconCls	: 'add',
						width	: 50,
						handler	: show_addSubject,
						
						}), 
						
						new Ext.Toolbar.Button({
                        text	: 'Edit',
                        iconCls	: 'edit',
						width	: 50,
                 
						}), 
						
						new Ext.Toolbar.Button({
						text	: 'Delete',
						iconCls	: 'delete',	
						width	: 50,
						})
					],
			
		bbar		: subjectsPaging,	
	});

	mytabs.add(subjectsGrid);
	
	
	// add subject: fields
	
	var subjectCode = new Ext.form.TextField({
		name		: 'subject_code',
		allowBlank	: false,
		fieldLabel	: 'Subject Code',
		value		: '',
		blankText	: 'Enter Subject Code',
		msgTarget	: 'side', 		
	});
	
	var subjectDesc = new Ext.form.TextField({
		name		: 'subject_desc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		value		: '',
		blankText	: 'Enter Description',
		msgTarget	: 'side', 	
	});
		
	var subjectUnits = new Ext.form.TextField({
		name		: 'subject-units',
		width		: 40,
		allowBlank	: false,
		fieldLabel	: 'Units',
		value		: '',
		blankText	: 'Enter Units',
		msgTarget	: 'side', 	
	});
	
	var subjectCollege = new Ext.form.ComboBox({
		store			: comboCollege, //direct array data
		id				: 'subject-college',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'College',
		emptyText		: 'Select a College...',
		selectOnFocus	: true,
		displayField	: 'college_desc',
		valueField		: 'collegeid',
		hiddenName		: 'subject_college',
		listeners		:{	select	:{	fn	:function(combo, value) 
											{
												var combodept = Ext.getCmp('subject-department');        
												combodept.clearValue();
												combodept.store.filter('collegeid', combo.getValue());
											}
									}
						}	
	});
	
	var subjectDepartment = new Ext.form.ComboBox({
		store			: departmentsStore, //direct array data
		id				: 'subject-department',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'Department',
		emptyText		: 'Select a Department...',
		selectOnFocus	: true,
		valueField		: 'departmentid',
		displayField	: 'department_desc',
		hiddenName		: 'subject_department',
		mode			:'local',
		lastQuery		:'',	
	});
	
	
	var subjectTypes = new Ext.ux.form.SuperBoxSelect({
		store			: typesStore,
		xtype			: 'superboxselect',
		fieldLabel		: 'Type',
		id				: 'subject-type',
		mode			: 'local',
		displayField	: 'type_code',
		valueField		: 'typeid',
		name			: 'subject-type[]',
		triggerAction	: 'all',
		mode			: 'remote',
		queryDelay		: 0,
	});

	var subjectRoomOptions = new Ext.ux.form.SuperBoxSelect({
		store			: comboCollege,
		xtype			: 'superboxselect',
		fieldLabel		: 'Room Options',
		allowBlank		: false,
		id				: 'subject-room-options',
		mode			: 'local',
		displayField	: 'college_code',
		valueField		: 'collegeid',
		name			: 'subject-room-options[]',
		triggerAction	: 'all',
		queryDelay		: 0,
	});	
	
	var subjectRoomItems = new Ext.ux.form.SuperBoxSelect({
		store			: comboItems,
		xtype			: 'superboxselect',
		fieldLabel		: 'Room Items',
		allowBlank		: false,
		id				: 'subject-room-items',
		mode			: 'local',
		displayField	: 'item_desc',
		valueField		: 'itemid',
		name			: 'subject-room-items[]',
		triggerAction	: 'all',
		queryDelay		: 0,
	});	

		
	//add subject: form
	var create_subject = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createsubject',
		frame			: true,		
		bodyStyle		: 'padding:5px 5px 0',
		defaults		: {width: 200},
		url 			: 'models/add-subject.php',		
		items			: [subjectCode, subjectDesc, subjectUnits, subjectCollege, subjectDepartment, subjectTypes, subjectRoomOptions, subjectRoomItems],
		buttons			: [	{
								text	: 'Add',
								formBind: true,
								handler	: addSubject, 
																						
														
														
							},
							{
								text	: 'Cancel',
								handler	: 	function()
											{
												create_subject.getForm().reset();
												close();
											},
							},
			
							{
								text	: 'Clear',
								handler	: 	function()
											{
												create_subject.getForm().reset();
												close();
											},
							},
						]
	});

	//add subject: window
	
	function show_addSubject()
	{
		if(!win)
		{
			win = new Ext.Window({
					title		: 'Add Subject',
					layout		: 'fit',
					width		: 450,
			        height		: 400,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_subject],
			});
		}
		win.show();
	}
	
	//add subject: function
	
	function addSubject()
	{
	
		create_subject.getForm().submit(
		{
			method			: 'POST', 
			standardSubmit	: true,
			waitTitle		: 'Connecting', 
			waitMsg			: 'Saving data...',
			success			: function(form, action) 
								{
								   Ext.Msg.alert('Success', action.result.msg);
								   create_subject.getForm().reset();
								   close();
								   window.location.reload
								},

			failure			: function(form, action) 
								{
									Ext.Msg.alert('Failure', action.result.msg);
								}
		});
	}
	
/*********************** Types ****************************************/	
		
	var typesPaging = new Ext.PagingToolbar({
		pageSize	:15,
		store		: typesStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Types {0} - {1} of {2}',
		emptyMsg	: "No Types to display",	
	});
	
	var typesGrid = new Ext.grid.GridPanel({ 
		store		: typesStore,
		id			: 'types-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: typesModel,
		sm			: typescb,	
		title		: 'Types', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button(
						{
							text	: 'Add',
							iconCls	: 'add',
							width	: 50,
							handler	: show_addType,
			
						}), 
						
						new Ext.Toolbar.Button(
						{
							text	: 'Edit',
							iconCls	: 'edit',
							width	: 50,
                 
						}), 
						
						new Ext.Toolbar.Button(
						{
							text	: 'Delete',
							iconCls	: 'delete',	
							width	: 50,
			
						})
					],
		bbar: 		typesPaging,
	});

	mytabs.add(typesGrid);
	typesStore.load({params:{start:0, limit:15}});
	
	//add types: fields
	var typeCode = new Ext.form.TextField({
		name		: 'typecode',
		allowBlank	: false,
		fieldLabel	: 'Type Code',
		value		: '',
		blankText	: 'Enter Type Code',
		msgTarget	: 'side', 		
	});
	
	var typeDesc = new Ext.form.TextField({
		name		: 'typedesc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		/* inputType: 'password', */
		value		: '',
		blankText	:'Enter Description',
		msgTarget	:'side', 
		
	});
	
	//add type: form
	
	var create_type = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createtype',
		frame			: true,		
		bodyStyle		: 'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-type.php',		
		items			: [typeCode,typeDesc],
		buttons			: [	{
								text		: 'Add',
								formBind	: true,
								handler		: addType,
			
							},
							{
								text		: 'Cancel',
								handler		:	function()
												{
													create_type.getForm().reset();
													close();
												},
							}
						]

	});
	
	//add type: window
	
	function show_addType()
	{
		if(!win)
		{
			win = new Ext.Window({
					title		: 'Add Type',
					layout		:'fit',
					width		: 450,
			        height		: 350,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_type],
			});
		}
		win.show();
	}
	
	//add type: function
	
	function addType()
	{
		create_type.getForm().submit(
		{
			method:'POST', 
			waitTitle:'Connecting', 
			waitMsg:'Saving data...',
			success: function(form, action) {
					   Ext.Msg.alert('Success', action.result.msg);
					   create_type.getForm().reset();
					   close();
					   window.location.reload
					},

			failure: function(form, action) {
					   Ext.Msg.alert('Failure', action.result.msg);
					}

		});
	}
/*********************** Items ****************************************/	
	
	
	
	var itemsPaging = new Ext.PagingToolbar({
		pageSize	: 15,
		store		: itemsStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Items {0} - {1} of {2}',
		emptyMsg	: "No Items to display",	
	});
	
	var itemsGrid = new Ext.grid.GridPanel({ 
		store		: itemsStore,
		id			: 'items-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: itemsModel,
		sm			: itemscb,	
		title		: 'Items', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
                        text	: 'Add',
						iconCls	: 'add',
						width	: 50,
						handler	: show_addItem,
						
                  
						}),
						
						new Ext.Toolbar.Button({
                        text	: 'Edit',
                        iconCls	: 'edit',
						width	: 50,
                 
						}), 
						new Ext.Toolbar.Button({
						text	: 'Delete',
						iconCls	: 'delete',	
						width	: 50,
						
                       
              
						})
					],
		
		bbar		: itemsPaging,
	
	});

	mytabs.add(itemsGrid);
	
	
	//add items: fields
	
	var itemCode = new Ext.form.TextField({
		name		: 'itemcode',
		allowBlank	: false,
		fieldLabel	: 'Item Code',
		value		: '',
		blankText	: 'Enter Item Code',
		msgTarget	: 'side', 
			
	});
	
	var itemDesc = new Ext.form.TextField({
		name		: 'itemdesc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		/* inputType: 'password', */
		value		: '',
		blankText	:'Enter Description',
		msgTarget	:'side', 
			
	});
	
	//add type: form
	
	var create_item = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createitem',
		frame			: true,		
		bodyStyle		:'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-item.php',		
		items			: [itemCode,itemDesc],
		buttons			: [	{
								text		: 'Add',
								formBind	: true,
								handler		: addItem,
			
							},
							{
								text		: 'Cancel',
								handler		: 	function()
												{
													create_item.getForm().reset();
													close();
												},
							}
						]

	});
	
	//add item: window
	
	function show_addItem()
	{
		if(!win)
		{
			win = new Ext.Window({
					title		: 'Add Item',
					layout		:'fit',
					width		: 450,
					height		: 350,
					closeAction	: 'hide',
					closable	: true,
					resizable	: false,
					modal		: true,
					plain		: true,  
					items		: [create_item],
			});
		}
		win.show();
	}
	
	//add type: function
	
	function addItem()
	{
		create_item.getForm().submit(
		{
			method		:'POST', 
			waitTitle	:'Connecting', 
			waitMsg		:'Saving data...',
			success		: 	function(form, action) 
							{
							   Ext.Msg.alert('Success', action.result.msg);
							   create_item.getForm().reset();
							   close();
							   window.location.reload
							},

			failure		: 	function(form, action) 
							{
								Ext.Msg.alert('Failure', action.result.msg);
							}

		});
	}
/*********************** Scope ****************************************/	
	
	var scopesPaging = new Ext.PagingToolbar({
		pageSize		: 15,
		store			: scopesStore,
		displayInfo		: true,
		displayMsg		: 'Displaying Scopes {0} - {1} of {2}',
		emptyMsg		: "No Scopes to display",	
	});
	
	
	var scopesGrid = new Ext.grid.GridPanel({ 
		store		: scopesStore,
		id			: 'scopes-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: scopesModel,
		sm			: scopescb,	
		title		: 'Scopes', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
                        text	: 'Add',
						iconCls	: 'add',
						width	: 50,
						handler	: show_addScope,
						
                  
						}), 
						new Ext.Toolbar.Button({
                        text	: 'Edit',
                        iconCls	: 'edit',
						width	: 50,
                 
						}), 
						new Ext.Toolbar.Button({
                        text	: 'Delete',
						iconCls	: 'delete',	
						width	: 50,
						
						})
					],
		
		bbar		: scopesPaging,
	});

	mytabs.add(scopesGrid);
	scopesStore.load({params:{start:0, limit:15}});
	
	//add scope: fields
	var scopeDesc = new Ext.form.TextField({
		name		: 'scopedesc',
		allowBlank	: false,
		fieldLabel	: 'Scope Description',
		value		: '',
		blankText	: 'Enter Scope Description',
		msgTarget	: 'side', 		
	});
	
	
	//add scope: form
	
	var create_scope = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createscope',
		frame			: true,		
		bodyStyle		:'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-scope.php',		
		items			: [scopeDesc],
		buttons			: [	{
								text		: 'Add',
								formBind	: true,
								handler		: addScope,
			
							},
							{	
								text		: 'Cancel',
								handler		: 	function()
												{
													create_scope.getForm().reset();
													close();
												},
							}
						]

	});
	
	//add scope: window
	
	function show_addScope()
	{
		if(!win)
		{
			win = new Ext.Window({
					title		: 'Add Scope',
					layout		:'fit',
					width		: 450,
			        height		: 200,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_scope],
			});
		}
		win.show();
	}
	
	//add scope: function
	
	function addScope()
	{

		create_scope.getForm().submit(
		{
			method		:'POST', 
			waitTitle	:'Connecting', 
			waitMsg		:'Saving data...',
			success		: 	function(form, action) 
							{
							   Ext.Msg.alert('Success', action.result.msg);
							   create_scope.getForm().reset();
							   close();
							   window.location.reload
							},

			failure		: 	function(form, action) 
							{
								Ext.Msg.alert('Failure', action.result.msg);
							}

		});
	}
	
/*********************** Day ****************************************/	
	
	var daysPaging = new Ext.PagingToolbar({
		pageSize		:15,
		store			: daysStore,
		displayInfo		: true,
		displayMsg		: 'Displaying Days {0} - {1} of {2}',
		emptyMsg		: "No Days to display",	
	});
	
	var daysGrid = new Ext.grid.GridPanel({ 
		store		: daysStore,
		id			: 'days-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: daysModel,
		sm			: dayscb,	
		title		: 'Days', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
                        text	: 'Add',
						iconCls	: 'add',
						width	: 50,
						handler	: show_addDay,
						
                  
									}), 
						new Ext.Toolbar.Button({
						text	: 'Edit',
						iconCls	: 'edit',
						width	: 50,
							 
						}), 
						new Ext.Toolbar.Button({
                        text	: 'Delete',
						iconCls	: 'delete',	
						width	: 50,
		
						})
					],
		
		bbar		: daysPaging,
	});

	mytabs.add(daysGrid);
	daysStore.load({params:{start:0, limit:15}});
	
	//add days: fields
	
	var dayCode = new Ext.form.TextField({
		name		: 'daycode',
		allowBlank	: false,
		fieldLabel	: 'Day Code',
		value		: '',
		blankText	:'Enter Day Code',
		msgTarget	:'side', 
			
	});
	
	
	//add scope: form
	
	var create_day = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 350,
		id				: 'createday',
		frame			: true,		
		bodyStyle		:'padding:5px 5px 0',
		defaults		: {width: 200},
		url				: 'models/add-day.php',		
		items			: [dayCode],
		buttons			: [	{
								text	: 'Add',
								formBind: true,
								handler	: addDay,
			
							},
							{
								text	: 'Cancel',
								handler	: 	function()
											{
												create_day.getForm().reset();
												close();
											},
							}
						]

	});
	
	//add scope: window
	
	function show_addDay()
	{
		if(!win)
		{
			win = new Ext.Window({
					title		: 'Add Day',
					layout		:'fit',
					width		: 450,
			        height		: 200,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_day],
			});
		}
		win.show();
	}
	
	//add scope: function
	
	function addDay()
	{
		create_day.getForm().submit(
		{
				method		: 'POST', 
				waitTitle	: 'Connecting', 
				waitMsg		: 'Saving data...',
				success		: 	function(form, action) 
								{
								   Ext.Msg.alert('Success', action.result.msg);
								   create_day.getForm().reset();
								   close();
								   window.location.reload
								},

				failure		: 	function(form, action) 
								{
								   Ext.Msg.alert('Failure', action.result.msg);
								}

		});
	}
	
/*********************** Time ****************************************/	

	var timePaging = new Ext.PagingToolbar({
		pageSize	: 15,
		store		: timeStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Time {0} - {1} of {2}',
		emptyMsg	: "No Time to display",	
	});
	
	var timeGrid = new Ext.grid.GridPanel({ 
		store		: timeStore,
		id			: 'time-grid',
		stripeRows	: true,
		height		:200, 
		width		:600, 
		cm			: timeModel,
		sm			: timecb,	
		title		: 'Time', 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
                        text	: 'Add',
						iconCls	: 'add',
						width	: 50,
						handler	: show_addTime,
						
                  
						}), 
						
						new Ext.Toolbar.Button({
                        text	: 'Edit',
                        iconCls	: 'edit',
						width	: 50,
                 
						}), 
						new Ext.Toolbar.Button({
                        text	: 'Delete',
						iconCls	: 'delete',	
						width	: 50,
						
                       
              
						})
					],
		bbar		: timePaging,
	});

	mytabs.add(timeGrid);
	timeStore.load({params:{start:0, limit:15}});
	
	
	//add time: fields
 	var start = new Ext.form.TextField({
		name		: 'time-start',
		allowBlank	: false,
		value		: '',
		blankText	: 'Enter Time Description',
		width		: 50,
			
	});
	
	var end = new Ext.form.TextField({
		name		: 'time-end',
		allowBlank	: false,
		value		: '',
		blankText	: 'Enter Time Description',
		width		: 50,
			
	});
 
	
	var scope = new Ext.form.CompositeField({
		fieldLabel	: 'Time Range',
		msgTarget	: 'under', 
		items		: [	{xtype: 'textfield', name: 'time-start', allowBlank: false, width: 50, blankText: 'Enter Start Range'}, 
						{xtype: 'displayfield', value: '-'},
						{xtype: 'textfield', name: 'time-end', allowBlank: false, width: 50, blankText: 'Enter End Range'},
					]
	});
	
	//add time: form
	
	var create_time = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 100,		
		width			: 400,
		id				: 'createtime',
		frame			: true,		
		bodyStyle		:'padding:5px 5px 0',
		defaults		: {width	: 200},
		url				: 'models/add-time.php',		
		items			: [/* {
							xtype		: 'compositefield',
							fieldLabel	: 'Time Range',
							msgTarget	: 'under', 
							items		: [	{xtype: 'textfield', name: 'time-start', allowBlank: false, width: 50, blankText: 'Enter Start Range'}, 
											{xtype: 'displayfield', value: '-'},
											{xtype: 'textfield', name: 'time-end', allowBlank: false, width: 50, blankText: 'Enter End Range'},
										]
						} */ scope],
		buttons			: [	{
								text	: 'Add',
								formBind: true,
								handler	: addTime,
			
							},
							{
								text	: 'Cancel',
								handler	: 	function()
											{
											create_time.getForm().reset();
											close();
											},
							}
						]
	});
	
	//add time: window
	
	function show_addTime()
	{
		if(!win)
		{
			win = new Ext.Window({
				title		: 'Add Time Description',
				layout		:'fit',
				width		: 450,
				height		: 200,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				plain		: true,  
				items		: [create_time],
			});
		}
		win.show();
	}
	
	//add time: function
	
	function addTime()
	{
		create_time.getForm().submit(
		{
			method		:'POST', 
			waitTitle	:'Connecting', 
			waitMsg		:'Saving data...',
			success		: 	function(form, action) 
							{
							   Ext.Msg.alert('Success', action.result.msg);
							   create_time.getForm().reset();
							   close();
							   window.location.reload
							},

			failure		: 	function(form, action) 
							{
							   Ext.Msg.alert('Failure', action.result.msg);
							}

		});
	}

/*********************** CONTAINER ****************************************/
	var treePanel = new Ext.tree.TreePanel({
    	id: 'tree-panel',
    	title: 'Configuration',
        region:'north',
        split: true,
        height: 300,
        minSize: 150,
        autoScroll: true,
        
        // tree-specific configs:
        rootVisible: false,
        lines: false,
        singleExpand: true,
        useArrows: true,
     
    });

	var root = new Ext.tree.TreeNode({
        text: 'Char',
        draggable:false,
        id:'source'
    });
	
	treePanel.setRootNode(root);
	
	
	
	var detailsPanel = new Ext.Panel({
		id			: "details-panel",
		region		: 'center',
		title		: "Description",
		autoScroll	: true,
	});
	
	var header = new Ext.BoxComponent({
		renderTo	: 'header',
		region		: 'north',
		height		: 40, 
	});
	
	
	var west = new Ext.Panel({
		region		: 'west',
		width		: 150, 
		collapsible	: true,
		layout		: 'border',
		border		: false,
		split		: true,
		margins		: '2 0 5 5',
		minSize		: 100,
	    maxSize		: 500,
		items		: [treePanel, detailsPanel]
	});
	
	var viewport = new Ext.Viewport({
        layout	: 'border',
        items  	: [	 
					header, mytabs, west
				],
	});
    
});