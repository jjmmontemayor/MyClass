{
						xtype		: 'grouptabpanel',
						region		: 'center',
						tabWidth	: 130,
						activeGroup	: 0,
						items		: [	{
											mainItem	: 1,
											items		: [	{
																title	: 'College',
																tabTip	: 'Item 1',
																handler	: 	function()
																			{
																				mytabs.setActiveTab('college');
																			}
															},
															{
																title	: 'Attributes',
																tabTip	: 'Item 1',
																layout	: 'fit',
																items	: [mytabs],
															}
						
						
														]
										},
										{
											expanded	: true,
											items		: [	{
																title	: 'Configuration',
																iconCls	: 'add',
																tabTip	: 'Configuration tabtip',
																style	: 'padding: 10px;',
																html	: 'hello',
															}
														]
										
									
										}
									]
				
					}