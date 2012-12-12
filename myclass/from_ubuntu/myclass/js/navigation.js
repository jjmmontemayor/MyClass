
	
	var treeLoader = new Ext.tree.TreeLoader({
		dataUrl:'model/tree-data.php'
	});	

	var rootNode = new Ext.tree.AsyncTreeNode({
		text: 'Root'
	});
   
	var treePanel = new Ext.tree.TreePanel({
		region		: 'center',
		loader		: treeLoader,
		root		: rootNode,
		id			: 'tree-panel',
		title		: 'Configuration',
		iconCls		: 'configure',
		split		: true,
		height		: 300,
		minSize		: 150,
		rootVisible	: false,
        lines		: false,
        singleExpand: true,
        useArrows	: true,

	});
	
	treePanel.on('click', function(n){
    	var sn = this.selModel.selNode || {}; // selNode is null on initial selection
    	if(n.leaf && n.id != sn.id){  // ignore clicks on folders and currently selected node 
    		Ext.getCmp('content').layout.setActiveItem(n.id);
    	}
    });
    
    var settings = new Ext.Toolbar.Button({
        text	: 'General Settings',
		iconCls	: 'settings',
		width	: 50,
		height	: 30,
		id		: 'general-settings',
	});
	
	Ext.getCmp('general-settings').on('click', function(){
	
		Ext.getCmp('content').layout.setActiveItem(12);		
	});


	
	var generate = new Ext.Toolbar.Button({
        text	: 'Generate Schedule',
		iconCls	: 'generate',
		width	: 50,
		height	: 30,
		id		: 'generate-schedule',
	});
	
	Ext.getCmp('generate-schedule').on('click', function(){
	
		show_generateWindow();
		
	});
	
	function generateSchedule()
	{
		window.location = "/myclass/view/generate.php";
	}
	
	
	var chooseSchedule = new Ext.form.ComboBox({
		store			: schedulesStore, //direct array data
		id				: 'existing-schedule',
		typeAhead		: true,
		allowBlank		: false,
		editable		: false,
		triggerAction	: 'all',
		fieldLabel		: 'schoolyear_sem_version',
		emptyText		: 'Select a Schedule',
		selectOnFocus	: true,
		valueField		: 'scheduleid',
		displayField	: 'schedule_desc',
		hiddenName		: 'scheduleid',
		mode			:'local',
		lastQuery		:'',
		anchor			: '80%',		
	});

		
	var optionsExisting_form = new Ext.FormPanel({
		monitorValid	: true,
		id				: 'uploadschedule',
		frame			: true,	
		labelWidth		: 150,
		//url				: 'model/add-time.php',		
		items			: [chooseSchedule],
		style 			: 'margin: 10px',
		buttons			: [	{
							text	: 'Generate',
							formBind: true,
							handler : generateSchedule,
							},
							{
							text	: 'Cancel',
							handler	: function()
										{
											Ext.getCmp('existing-window').hide(); 
										},
							}
						]
	});
	
	var existingWindow;
	function show_existingWindow()
	{
		if(!existingWindow)
		{
			existingWindow = new Ext.Window({
				title		: 'Generate From Existing Schedule',
				width		: 500,
				id			: 'existing-window',
				autoHeight	: true,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				iconCls		: 'view',  
				items		: [{xtype: 'displayfield', html: 'Choose from the Existing Schedules:'},optionsExisting_form],
				bodyStyle	: 'font-size:12px;font-weight:bold;padding:10px',
				x			: 400,
				y			: 250,
				iconCls		: 'existing',
		
			});
		}
		existingWindow.show();
	}
	
	var dtimeLimit = new Ext.form.DisplayField({
		name		: 'time-limit',
		value		: '1200',
		fieldLabel	: 'time limit',
		autoWidth	: true,
		readOnly	: true,
	});
	
	var dantsPerColony = new Ext.form.DisplayField({
		name		: 'apc',
		value		: '1',
		fieldLabel	: 'apc',
		autoWidth	: true,
		readOnly	: true,
	});
		
	var dcg = new Ext.form.DisplayField({
		name		: 'cg',
		value		: '3',
		fieldLabel	: 'cg',
		readOnly	: true,	
	});
	
	var dalpha = new Ext.form.DisplayField({
		name		: 'alpha',
		value		: '1',
		fieldLabel	: 'alpha',
		readOnly	: true,	
	});

	var dbeta = new Ext.form.DisplayField({
		name		: 'beta',
		value		: '1',
		fieldLabel	: 'beta',
		readOnly	: true,	
	});

	var dpr = new Ext.form.DisplayField({
		name		: 'pr',
		value		: '0.2',
		fieldLabel	: 'pr',
		readOnly	: true,	
	});
	
	var dad = new Ext.form.DisplayField({
		name		: 'ad',
		value		: '5',
		fieldLabel	: 'ad',
		readOnly	: true,	
	});
	
	var dzap = new Ext.form.DisplayField({
		name		: 'zap',
		value		: '10',
		fieldLabel	: 'zap',
		readOnly	: true,	
	});
	
	var diap = new Ext.form.DisplayField({
		name		: 'iap',
		value		: '1000',
		fieldLabel	: 'iap',
		readOnly	: true,	
	});
	
	var dqi = new Ext.form.DisplayField({
		name		: 'qi',
		value		: '999999',
		fieldLabel	: 'qi',
		readOnly	: true,	
	});	
	
	var dm = new Ext.form.DisplayField({
		name		: 'm',
		value		: '1',
		fieldLabel	: 'm',
		readOnly	: true,	
	});
	
	var dfullEval = new Ext.form.DisplayField({
		name		: 'fullEval',
		value		: 'true',
		fieldLabel	: 'fullEval',
		readOnly	: true,	
	});
	
	var difs = new Ext.form.DisplayField({
		name		: 'ifs',
		value		: '10',
		fieldLabel	: 'ifs',
		readOnly	: true,	
	});
	
	var dls = new Ext.form.DisplayField({
		name		: 'dls',
		value		: 'true',
		fieldLabel	: 'ls',
		readOnly	: true,	
	});
	
	var dibu = new Ext.form.DisplayField({
		name		: 'ibu',
		value		: 'true',
		fieldLabel	: 'ibu',
		readOnly	: true,	
	});
	
	var dstr = new Ext.form.DisplayField({
		name		: 'str',
		value		: '12',
		fieldLabel	: 'str',
		readOnly	: true,	
	});
	
	var dpd = new Ext.form.DisplayField({
		name		: 'pd',
		value		: '1',
		fieldLabel	: 'pd',
		readOnly	: true,			
	});
	

	

	
	var optionsNew_form = new Ext.FormPanel({
		monitorValid	: true,
		id				: 'newschedule',
		frame			: true,	
		labelWidth		: 200,	
		style 			: 'margin: 10px',
		//url				: 'model/add-time.php',		
		items			: [dtimeLimit,dantsPerColony,dcg,dalpha,dbeta, dpr, dad, dzap, diap, dqi, dm, dfullEval, difs, dls, dibu, dstr, dpd],
		bodyStyle		: 'font-size:10px;padding:10px 5px 5px 15px;',
		buttons			: [	{
							text	: 'Generate',
							formBind: true,
							handler : generateSchedule,
							},
							{
							text	: 'Cancel',
							handler	: 	function()
										{
											Ext.getCmp('option-new-window').hide();	
										},
							}
						]
	});
	
	var newWindow;
	function show_newWindow()
	{
		if(!newWindow)
		{
			newWindow = new Ext.Window({
				title		: 'Generate New Schedule',
				width		: 500,
				id			: 'option-new-window',
				autoHeight	: true,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				iconCls		: 'view',  
				items		: [{xtype: 'displayfield', html: 'The following parameters have been configured on the General Settings Tab and will be used.:'},optionsNew_form],
				bodyStyle	: 'font-size:12px;padding:10px 5px 5px 5px;',
				x			: 400,
				y			: 80,
				iconCls		: 'new',
		
			});
		}
		newWindow.show();
	}
	
	var optionExisting = new Ext.form.Radio({
        name: 'options',
        id: 'option-existing',
        inputValue: '1',
        boxLabel: 'Generate From Existing Solution',
        height	: 30,
          
    });
    
    var optionNew = new Ext.form.Radio({
        name: 'options',
        id: 'option-new',
        inputValue: '0',
        boxLabel: 'Generate New Solution',
    });
    
    optionExisting.addListener('check',function() {
        Ext.getCmp('genwin').hide();
        Ext.getCmp('option-new').reset();
        Ext.getCmp('option-existing').reset();
        show_existingWindow();
    });
    
	
    optionNew.addListener('check',function() {
        Ext.getCmp('genwin').hide();
        Ext.getCmp('option-new').reset();
        Ext.getCmp('option-existing').reset();
        show_newWindow();
    });
    
	var genwin;
	function show_generateWindow()
	{
		if(!genwin)
		{
			genwin = new Ext.Window({
				title		: 'Generate Schedule Options',
				width		: 250,
				id			: 'genwin',
				autoHeight	: true,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				iconCls		: 'view',  
				items		: [optionExisting, optionNew],
				bodyStyle	: 'font-size:13px;padding:10px;',
				x			: 500,
				y			: 250,
				iconCls		: 'option',
		
			});
		}
		genwin.show();
	}
	

	var node = new Ext.Toolbar.Button({
        text		: 'Monitor Nodes',
		iconCls		: 'node',
		width		: 100,
		id			: 'view-nodes',
	});
	
	var cookie = new Ext.Toolbar.Button({
        text		: 'Monitor Cookies',
		iconCls		: 'cookie',
		width		: 100,
		autoHeight	: true,
		id			: 'view-cookies',
	});

	Ext.getCmp('view-nodes').on('click', function(){
		show_Nodes();
	});
	
	Ext.getCmp('view-cookies').on('click', function(){
		show_cookies();
	});
	

	var cookiefield = new Ext.form.DisplayField({
		name		: 'cookie-field',
		value		: 'Set Cookie: aaa',
		text		: 'Set Cookie',
		readOnly	: true,			
	});
	
	var nodefield = new Ext.form.DisplayField({
		name		: 'node-field',
		value		: 'Available Nodes: a@127.0.0.1',
		text		: 'Available Nodes',
		readOnly	: true,			
	});
	
	var nodes;
	function show_Nodes()
	{
		if(!nodes)
		{
			nodes = new Ext.Window({
				title		: 'Monitor Nodes',
				width		: 250,
				id			: 'nodes',
				autoHeight	: true,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,  
				items		: [nodefield],
				bodyStyle	: 'font-size:13px;padding:10px;',
				x			: 500,
				y			: 250,
				iconCls		: 'node',
		
			});
		}
		nodes.show();
	}
	
	
	var cookies;
	function show_cookies()
	{
		if(!cookies)
		{
			cookies = new Ext.Window({
				title		: 'Monitor Cookies',
				width		: 250,
				id			: 'cookies',
				autoHeight	: true,
				closeAction	: 'hide',
				closable	: true,
				resizable	: false,
				modal		: true,
				iconCls		: 'view',  
				items		: [cookiefield],
				bodyStyle	: 'font-size:13px;padding:10px;',
				x			: 500,
				y			: 250,
				iconCls		: 'cookies',
		
			});
		}
		cookies.show();
	}

	var solution = new Ext.Toolbar.Button({
        text		: 'View Schedules',
		iconCls		: 'view',
		width		: 70,
		height		: 30,
		id			: 'view-schedules',
	});

	Ext.getCmp('view-schedules').on('click', function(){
	
	Ext.getCmp('content').layout.setActiveItem(13);		
	
	});

    
