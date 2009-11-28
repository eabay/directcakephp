Ext.onReady(function(){
	Ext.Direct.addProvider(Ext.app.REMOTING_API);
	Ext.Direct.on('exception', function(e) {
        Ext.Msg.alert('Exception', e.message);
    });
    
    new Ext.Button({
        renderTo: Ext.getBody(),
        text: 'What is the time?',
        scale: 'large',
        handler: function() {
        	Ext.app.Time.get(function(result, e){
        	   Ext.Msg.alert('Response', result);
        	});
        }
    })
});