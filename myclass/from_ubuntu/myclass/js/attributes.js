Ext.onReady(function(){

	Ext.BLANK_IMAGE_URL = 'images/s.gif';
    Ext.QuickTips.init();



/*********************** Global Functions ****************************************/	

	
	
	
	function close(win) 
	{ 
		win.hide();
	}
	
	
/*********************** Courses ****************************************/
	
	var coursesPaging = new Ext.PagingToolbar({
		pageSize	: 34,
		store		: coursesStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Courses {0} - {1} of {2}',
		emptyMsg	: "No Courses to display",	
	});

    var courseGrid = new Ext.grid.GridPanel({ 
		store		: coursesStore,
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		id			: 'courses-grid', 
		cm			: courseModel, 
		title		: 'Courses',
		viewConfig	: { forceFit:true }, 
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
							}),
						new Ext.Toolbar.Button({
						text	: 'Include Selected Courses',
						iconCls	: 'include',	
						width	: 50,
							})	
						],
		
		bbar		: coursesPaging,	
			
	});
	
		
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
		fieldLabel	: 'Offerings',
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
		url				: 'model/add-course.php',		
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
											close(addcourse);
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
	var addcourse;
	function show_addCourse()
	{
		if(!addcourse){
			addcourse = new Ext.Window({
					title		: 'Add Course',
					layout		:'fit',
					width		: 450,
			        height		: 350,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_course],
			});
		}
		addcourse.show();
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
							   close(addcourse);
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
		pageSize	: 34,
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
		viewConfig	: { forceFit:true },
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
							}),
						new Ext.Toolbar.Button({
						text	: 'Include Selected Locations',
						iconCls	: 'include',	
						width	: 50,
						handler	: attachLocations,
							})	
						],
		
		bbar		: locationsPaging,	
			
	});
	
	function attachLocations(){
		
		alert("Are you sure you want to attach the following locations to search?");
	
	
	}
	
	
	
	
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
		url				: 'model/add-location.php',		
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
												close(addlocation);
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
	var addlocation;
	function show_addLocation()
	{
		if(!addlocation){
			addlocation = new Ext.Window({
					title		: 'Add Location',
					layout		:'fit',
					width		:450,
			        height		:350,
					x			: 200,
					y			: 10,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_location],
			});
		}
		addlocation.show();
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
							   close(addlocation);
							   window.location.reload
							},

				failure		: function(form, action) {
								Ext.Msg.alert('Failed', action.result.msg);
							}
			}
		);
	}
	
/*********************** Timeslots ****************************************/

	var timeslotPaging = new Ext.PagingToolbar({
		pageSize	: 34,
		store		: timeslotsStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Timeslots {0} - {1} of {2}',
		emptyMsg	: "No Timeslots to display",	
	});

	
    var timeslotsGrid = new Ext.grid.GridPanel({ 
		store		: timeslotsStore,
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		id			: 'timeslots-grid', 
		cm			: timeslotsModel, 
		title		: 'Timeslots',
		viewConfig	: { forceFit:true }, 
		labelAlign	: 'top',
		tbar		: [	new Ext.Toolbar.Button({
							text	: 'Add',
							iconCls	: 'add',
							id		: 'add-timeslot',
							handler	: show_addTimeslot,
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
							}),
						new Ext.Toolbar.Button({
						text	: 'Include Selected Timeslots',
						iconCls	: 'include',	
						width	: 50,
							})		
						],
		
		bbar		: timeslotPaging,	
			
	});
	
	var matches = new Ext.form.DisplayField({
		fieldLabel		: 'Timeslot Mappings Generated',
		name		: 'matches',
		id			: 'match',
		value		: '',
	});
	
	
	var timeslotName = new Ext.form.TextField({
		name		: 'timeslot_desc',
		allowBlank	: false,
		fieldLabel	: 'Description',
		value		: '',
		blankText	:'Enter Description',
		msgTarget	:'side',
		anchor		: '60%',	
	});

	var timeslotPriority = new Ext.form.RadioGroup({
		allowBlank	: false,
		fieldLabel	: 'Priority',
		items		: [
					{boxLabel: 'True',	 name		: 'timeslot_priority', inputValue: 'true', checked:true },
					{boxLabel: 'False',  name		: 'timeslot_priority', inputValue: 'false',},
		]	
	});
	

	
	var timeslotTime = new Ext.ux.form.SuperBoxSelect({
		store			: timeStore,
		xtype			: 'superboxselect',
		fieldLabel		: 'Time',
		allowBlank		: false,
		id				: 'timeslot-time',
		mode			: 'local',
		displayField	: 'time_desc',
		valueField		: 'time_desc',
		name			: 'timeslot_time[]',
		triggerAction	: 'all',
		queryDelay		: 0,
		height			: 40,
	});
	
		var timeslotDay = new Ext.ux.form.SuperBoxSelect({
		store			: daysStore,
		xtype			: 'superboxselect',
		fieldLabel		: 'Day',
		allowBlank		: false,
		id				: 'timeslot-day',
		hiddenValue		: 'day_code',
		mode			: 'local',
		displayField	: 'day_code',
		valueField		: 'day_code',
		name			: 'timeslot_day[]',
		triggerAction	: 'all',
		queryDelay		: 0,
		height			: 40,
		width			: 200,
	});	
	
	var timeslotAddButton = new Ext.Button({
		id			: 'timeslot-add-button',
		text		: 'Add',
		width		: 50,
		height		: 30,
		style		: 'padding: 5px 0 0 0',
	});
		
	Ext.getCmp('timeslot-add-button').on('click', function(){
		
		var day = Ext.getCmp('timeslot-day').getValue() ;
		var time = Ext.getCmp('timeslot-time').getValue();
		
		var temp = new Array();
		temp = day.split(',');
		
		var temp2 = new Array();
		temp2 = time.split(',');
		
		var string = "";
		
		for(i=0;i<temp.length;i++)
		{
			for(j=0;j<temp2.length;j++)
			{
				var string2 = temp[i] + " - " + temp2[j] + "<br/>" ;
				Ext.getCmp('match').setRawValue(string.concat(string2));
				
			}
			
		}
		
		
		//alert("Day: " + day3 + "Time: " + time);
	});
	
	var timeslotRemoveButton = new Ext.Button({
		id			: 'timeslot-remove-button',
		text		: 'Remove',
		width		: 50,
		height		: 30,
		style		: 'padding: 5px 0 0 0',
	});
		
	var dayTimePanel = new Ext.Panel({
		layout	: 'column',
		items	: [
			{columnWidth: .25, bodyStyle:'padding:2px;border: 0px;', items:[{xtype: 'displayfield', html: 'Day'},timeslotDay]},
			{columnWidth: .25, bodyStyle:'padding:2px;border: 0px;', items:[{xtype: 'displayfield', html: 'Time'}, timeslotTime]},
			{columnWidth: .25, bodyStyle:'padding:2px;border: 0px;', items:[timeslotAddButton, timeslotRemoveButton]},
			
		],
	});

	var create_timeslot = new Ext.FormPanel({
		monitorValid	: true,
		labelWidth		: 125,		
		width			: 900,
		id				: 'createtimeslot',
		frame			: true,		
		bodyStyle		: 'padding:5px 5px 0',
		//url				: 'model/add-location.php',		
		items			: [timeslotName, timeslotPriority,dayTimePanel,matches],
		buttons			: [{
								text	: 'Add',
								formBind: true,	
								handler	: addTimeslot,
							},
							{
								text	: 'Cancel',
								handler	:	function(){
												create_timeslot.getForm().reset();
												close(addtimeslot);
											},
							},
							{
								text	: 'Clear',
								handler	: 	function()
											{
												create_timeslot.getForm().reset();
											},
							},							
							]

	});

	var addtimeslot;
	function show_addTimeslot()
	{
		if(!addtimeslot){
			addtimeslot = new Ext.Window({
					title		: 'Add Timeslot',
					width		: 900,
					autoHeight	: true,			   
					x			: 200,
					y			: 10,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_timeslot],
					x			: 200,
					y			: 80,
			});
		}
		addtimeslot.show();
	}	
	
	function addTimeslot()
	{

		create_timeslot.getForm().submit(
			{
				method		:'POST', 
				waitTitle	:'Connecting', 
				waitMsg		:'Saving data...',
				success		: function(form, action) {
							   Ext.Msg.alert('Success', action.result.msg);
							   create_timeslot.getForm().reset();
							   close(addtimeslot);
							   window.location.reload
							},

				failure		: function(form, action) {
								Ext.Msg.alert('Failed', action.result.msg);
							}
			}
		);
	}
	


/*********************** Faculty ****************************************/
	var facultyPaging = new Ext.PagingToolbar({
		pageSize	: 34,
		store		: facultiesStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Faculties {0} - {1} of {2}',
		emptyMsg	: "No Faculties to display",	
	});

    var facultiesGrid = new Ext.grid.GridPanel({ 
		store		: facultiesStore,
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		id			: 'faculties-grid', 
		cm			: facultiesModel, 
		title		: 'Faculties', 
		labelAlign	: 'top',
		tbar		: [new 	Ext.Toolbar.Button({
							text	: 'Add',
							iconCls	: 'add',
							width	: 50,
							handler	: show_addFaculty,
							
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
							}),
						new Ext.Toolbar.Button({
						text	: 'Include Selected Faculties',
						iconCls	: 'include',	
						width	: 50,
						handler	: attachFaculties,
							})		
						],
		
		bbar		: facultyPaging,	
			
	});
	
	function attachFaculties(){
		
		alert("Are you sure you want to attach the following faculty profiles?");
	
	
	}
	
	var facultyName = new Ext.form.TextField({
		name		: 'faculty_desc',
		allowBlank	: false,
		fieldLabel	: 'Name',
		value		: '',
		blankText	:'Enter Name',
		msgTarget	:'side',
		anchor		: '98%'	
	});
	
	var facultyCollege = new Ext.form.ComboBox({
		store			: comboCollege, //direct array data
		id				: 'faculty-college',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'College',
		emptyText		: 'Select a College...',
		selectOnFocus	: true,
		displayField	: 'college_desc',
		valueField		: 'collegeid',
		hiddenName		: 'faculty_college',
		anchor			: '95%',
		listeners		:{	select	:{	fn	:function(combo, value) 
											{
												var combodept = Ext.getCmp('faculty-department');        
												combodept.clearValue();
												combodept.store.filter('collegeid', combo.getValue());
											}
									}
						}	
	});
	
	var facultyDepartment = new Ext.form.ComboBox({
		store			: departmentsStore, //direct array data
		id				: 'faculty-department',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'Department',
		emptyText		: 'Select a Department...',
		selectOnFocus	: true,
		valueField		: 'departmentid',
		displayField	: 'department_desc',
		hiddenName		: 'faculty_department',
		mode			:'local',
		lastQuery		:'',
		anchor			: '95%',		
	});
	
	var facultyTargetLoad = new Ext.form.TextField({
		name		: 'faculty_target',
		allowBlank	: false,
		fieldLabel	: 'Target Load',
		value		: '',
		blankText	:'Enter Target Load',
		msgTarget	:'side',
		anchor		: '95%',
	});
	
	var facultyMaxLoad = new Ext.form.TextField({
		name		: 'faculty_maxload',
		allowBlank	: false,
		fieldLabel	: 'Max Load',
		value		: '',
		blankText	:'Enter Max Load',
		msgTarget	:'side',
		anchor			: '95%',
	});
	
	var facultyMinLoad = new Ext.form.TextField({
		name		: 'faculty_minload',
		allowBlank	: false,
		fieldLabel	: 'Min Load',
		value		: '',
		blankText	:'Enter Min Load',
		msgTarget	:'side',
		anchor			: '95%',
	});
	
	var facultyTargetLoad = new Ext.form.TextField({
		name		: 'faculty_targetload',
		allowBlank	: false,
		fieldLabel	: 'Target Load',
		value		: '',
		blankText	:'Enter Target Load',
		msgTarget	:'side',
		anchor		: '95%',
	});
	
	var facultyPrefTime = new Ext.ux.form.SuperBoxSelect({
		store			: comboTimeslot,
		xtype			: 'superboxselect',
		fieldLabel		: 'Time Preference',
		allowBlank		: false,
		id				: 'faculty-time-preference',
		mode			: 'local',
		displayField	: 'timeslot_desc',
		valueField		: 'timeslotid',
		name			: 'faculty_preftime[]',
		triggerAction	: 'all',
		queryDelay		: 0,
	});	
	
	var facultyPrefLoc = new Ext.ux.form.SuperBoxSelect({
		store			: comboLocation,
		xtype			: 'superboxselect',
		fieldLabel		: 'Location Preference',
		allowBlank		: false,
		id				: 'faculty-location-preference',
		mode			: 'local',
		displayField	: 'location_desc',
		valueField		: 'locationid',
		name			: 'faculty_prefloc[]',
		triggerAction	: 'all',
		queryDelay		: 0,
	});	
	
	var teachablesLoader = new Ext.tree.TreeLoader({
		dataUrl:'model/dynamic.php'
	});	

	var root = new Ext.tree.AsyncTreeNode({
		text: 'Root'
	});
	
	var teachables = new Ext.tree.TreePanel({
		loader			: teachablesLoader,
		root			: root,
		id				: 'faculty-teachables',
		title			: 'Faculty Teachables',
		split			: true,
		autoWidth		: true,
		height			: 250,
		rootVisible		: false,
		containerScroll	: true,
		autoScroll		: true,
		frame			: true,
		animate			: true,
	});
	
	var create_faculty = new Ext.FormPanel({
	monitorValid	:true,
	labelAlign		: 'top',
	height			: 600,	
	id				: 'createfaculty',
	frame			: true,		
	bodyStyle		:'padding:5px 5px 0',
	url				: 'model/add-faculty.php',		
	items			: [facultyName,
	{layout: 'column', items: 
		[
		{layout: 'form', columnWidth: .5, items:[facultyCollege,facultyMinLoad,] },
		{layout: 'form', columnWidth: .5, items:[facultyDepartment,facultyMaxLoad,] },
		{layout: 'form', columnWidth: .5, items:[facultyTargetLoad,] }, 
		{layout: 'form', columnWidth: .5, items:[facultyPrefTime,facultyPrefLoc, ] }, 
		]},
	teachables],
	buttons			: [	{
							text	: 'Add',
							formBind: true,
									
						},
						{
							text	: 'Cancel',
							handler	: function(){
										create_faculty.getForm().reset();
										close(addfaculty);
									},
						}
					]
	});
	
	
	var addfaculty;
	function show_addFaculty()
	{
		if(!addfaculty){
			addfaculty =	new Ext.Window({
					title		: 'Add Faculty',
					layout		:'fit',
					width		: 800,
					x			: 200,
					y			: 10,
					closeAction	: 'hide',
					closable	: true,
					resizable	: false,
					modal		: true,
					plain		: true,  
					items		: [create_faculty],
			});
		}
		
		addfaculty.show();
	}
	
	//add college: function
	

	
	

/*********************** Faculty Events****************************************/

	
	

/*********************** Colleges ****************************************/	

	var collegePaging = new Ext.PagingToolbar({
		pageSize		: 34,
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
		viewConfig	: { forceFit:true },
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
		url				: 'model/add-college.php',		
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
											close(addcol);
										},
							}
						]
	});
	
	//add college: window
	var addcol;
	function show_addCollege()
	{
		if(!addcol){
			addcol =	new Ext.Window({
					title		: 'Add College',
					layout		:'fit',
					width		: 450,
					height		: 200,
					closeAction	: 'hide',
					closable	: true,
					resizable	: false,
					modal		: true,
					plain		: true,  
					items		: [create_college],
			});
		}
		
		addcol.show();
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
						   close(addcol);
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
		url			: 'model/edit-college.php',
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
	var editcol;		
	function show_editCollege()
	{
		if(!editcol){
			editcol = new Ext.Window(
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
		editcol.show();
	}
	
	function loadForm(theid)
	{
		edit_college.getForm().load(
		{
			url		: 'model/select-college.php',
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
		pageSize	: 34,
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
		viewConfig	: { forceFit:true }, 
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
		url				: 'model/add-department.php',		
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
											close(addDept);},
							}
						]
	});
	
	
	//add window
	var addDept;
	function show_addDepartment()
	{
		if(!addDept)
		{
			addDept = new Ext.Window({
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
		addDept.show();
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
								close(addDept);
							},

			failure		: 	function(form, action) 
							{
								Ext.Msg.alert('Failure', action.result.msg);
							}

		});
	}
	
/*********************** Subjects ****************************************/	
	
	var subjectsPaging = new Ext.PagingToolbar({
		pageSize	: 34,
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
		url 			: 'model/add-subject.php',		
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
												close(addsubj);
											},
							},
			
							{
								text	: 'Clear',
								handler	: 	function()
											{
												create_subject.getForm().reset();
												close(addsubj);
											},
							},
						]
	});

	//add subject: window
	var addsubj;
	function show_addSubject()
	{
		if(!addsubj)
		{
			addsubj = new Ext.Window({
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
		addsubj.show();
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
								   close(addsubj);
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
		pageSize	: 34,
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
		viewConfig	: { forceFit:true }, 
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
		url				: 'model/add-type.php',		
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
													close(addtype);
												},
							}
						]

	});
	
	//add type: window
	var addtype;
	function show_addType()
	{
		if(!addtype)
		{
			addtype = new Ext.Window({
					title		: 'Add Type',
					layout		:'fit',
					width		: 450,
			        height		: 150,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_type],
			});
		}
		addtype.show();
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
					   close(addtype);
					   window.location.reload
					},

			failure: function(form, action) {
					   Ext.Msg.alert('Failure', action.result.msg);
					}

		});
	}
/*********************** Items ****************************************/	
	
	
	
	var itemsPaging = new Ext.PagingToolbar({
		pageSize	: 34,
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
		viewConfig	: { forceFit:true },
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
		url				: 'model/add-item.php',		
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
													close(additem);
												},
							}
						]

	});
	
	//add item: window
	var additem;
	function show_addItem()
	{
		if(!additem)
		{
			additem = new Ext.Window({
					title		: 'Add Item',
					layout		:'fit',
					width		: 450,
					height		: 150,
					closeAction	: 'hide',
					closable	: true,
					resizable	: false,
					modal		: true,
					plain		: true,  
					items		: [create_item],
			});
		}
		additem.show();
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
							   close(additem);
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
		pageSize		: 34,
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
		viewConfig	: { forceFit:true }, 
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
		url				: 'model/add-scope.php',		
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
													close(addscope);
												},
							}
						]

	});
	
	//add scope: window
	
	var addscope;
	function show_addScope()
	{
		if(!addscope)
		{
			addscope = new Ext.Window({
					title		: 'Add Scope',
					layout		:'fit',
					width		: 450,
			        height		: 125,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_scope],
			});
		}
		addscope.show();
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
							   close(addscope);
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
		pageSize		: 34,
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
		viewConfig	: { forceFit:true }, 
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
		url				: 'model/add-day.php',		
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
												close(addday);
											},
							}
						]

	});
	
	//add scope: window
	
	var addday;
	function show_addDay()
	{
		if(!addday)
		{
			addday = new Ext.Window({
					title		: 'Add Day',
					layout		:'fit',
					width		: 450,
			        height		: 125,
					closeAction	: 'hide',
					closable	: true,
			        resizable	: false,
					modal		: true,
			        plain		: true,  
					items		: [create_day],
			});
		}
		addday.show();
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
								   close(addday);
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
		pageSize	: 34,
		store		: timeStore,
		displayInfo	: true,
		displayMsg	: 'Displaying Time {0} - {1} of {2}',
		emptyMsg	: "No Time to display",	
	});
	
	var timeGrid = new Ext.grid.GridPanel({ 
		store		: timeStore,
		id			: 'time-grid',
		stripeRows	: true,
		height		: 200, 
		width		: 600, 
		cm			: timeModel,
		sm			: timecb,	
		title		: 'Time',
		viewConfig	: { forceFit:true }, 
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
		url				: 'model/add-time.php',		
		items			: [scope],
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
											close(addtime);
											},
							}
						]
	});
	
	//add time: window
	
	var addtime;
	function show_addTime()
	{
		if(!addtime)
		{
			addtime = new Ext.Window({
				title		: 'Add Time Description',
				layout		:'fit',
				width		: 450,
				height		: 125,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				plain		: true,  
				items		: [create_time],
			});
		}
		addtime.show();
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
							   close(addtime);
							   window.location.reload
							},

			failure		: 	function(form, action) 
							{
							   Ext.Msg.alert('Failure', action.result.msg);
							}

		});
	}

/*********************** PANELS ****************************************/
	

    
var schedulesGrid = new Ext.grid.GridPanel({ 
	store		: schedulesStore,
	id			: 'schedules-grid',
	stripeRows	: true,
	height		: 200, 
	width		: 600, 
	cm			: schedulesModel,
	title		: 'Schedules',
	viewConfig	: { forceFit:true }, 
	labelAlign	: 'top',
});


	var detailsPanel = new Ext.Panel({
		id			: "details-panel",
		region		: 'north',
		title		: "Schedule",
		autoScroll	: true,
		height		: 150,
		tbar		: [{
            			xtype: 'buttongroup',
            			columns: 1,
            			defaults: {
                					scale: 'large',
            				 	 },
						items: [generate, solution, settings ], 
						}],
	});
	
	
	var header = new Ext.BoxComponent({
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
	
	var content = ({
		id			: 'content',
		layout		: 'card',
        activeItem	: 0,
        width		: 875,
        plain		: true,
        defaults	: {autoScroll: true},
		region		: 'center',
		margins		: '2 5 5 0',
		items		: [courseGrid, locationsGrid, timeslotsGrid, facultiesGrid, collegeGrid, departmentsGrid, subjectsGrid, typesGrid, itemsGrid, scopesGrid, daysGrid, timeGrid, settingsPanel, schedulesGrid]
	});
	
/*********************** CONTAINER ****************************************/	
	
	var viewport = new Ext.Viewport({
        layout	: 'border',
        items  	: [	 
					header, content, west
				],
	});
});
