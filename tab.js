function getCurrentTabUrl(callback) {
  // Query filter to be passed to chrome.tabs.query - see
  // https://developer.chrome.com/extensions/tabs#method-query
  var queryInfo = {
    active: true,
    currentWindow: true
  };

  chrome.tabs.query(queryInfo, function(tabs) {
    // chrome.tabs.query invokes the callback with a list of tabs that match the
    // query. When the popup is opened, there is certainly a window and at least
    // one tab, so we can safely assume that |tabs| is a non-empty array.
    // A window can only have one active tab at a time, so the array consists of
    // exactly one tab.
    var tab = tabs[0];

    // A tab is a plain object that provides information about the tab.
    // See https://developer.chrome.com/extensions/tabs#type-Tab
    var url = tab.url;

    // tab.url is only available if the "activeTab" permission is declared.
    // If you want to see the URL of other tabs (e.g. after removing active:true
    // from |queryInfo|), then the "tabs" permission is required to see their
    // "url" properties.
	//console.log(dataUrl, 'logged');
    console.assert(typeof url == 'string', 'tab.url should be a string');
    callback(url);
});
}
function getImageDataURL(callback)
{
	chrome.tabs.captureVisibleTab(null,{},function(dataUrl){
	var imageurl = dataUrl;
console.assert(typeof dataUrl == 'string', '');
callback(dataUrl);
		});
}
document.addEventListener('DOMContentLoaded', function() {
  getCurrentTabUrl(function(url) {

document.getElementById("myText").value = url;
document.getElementById("myDiv").style.display= 'none';

  });
  getImageDataURL(function(dataUrl)
  {
	  document.getElementById("myText1").value = dataUrl;
	  document.getElementById("myForm").submit();
	  
  });
});