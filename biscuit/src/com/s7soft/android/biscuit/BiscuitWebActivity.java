package com.s7soft.android.biscuit;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.webkit.CookieSyncManager;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.FrameLayout;
import android.widget.Toast;

public class BiscuitWebActivity extends Activity {

	public static WebView mWebView;
	public static String HOME = "http://www.google.com";

	private static final FrameLayout.LayoutParams ZOOM_PARAMS =
		new FrameLayout.LayoutParams(
		ViewGroup.LayoutParams.FILL_PARENT,
		ViewGroup.LayoutParams.WRAP_CONTENT,
		Gravity.BOTTOM);

    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        getWindow().requestFeature(Window.FEATURE_PROGRESS);
        setContentView(R.layout.webview);

        mWebView = (WebView) findViewById(R.id.webview);
        mWebView.getSettings().setJavaScriptEnabled(true);  // 웹뷰에서 자바스크립트실행가능
        mWebView.loadUrl(HOME);  // 구글홈페이지 지정
//        mWebView.setWebViewClient(new HelloWebViewClient());  // WebViewClient 지정
        CookieSyncManager.createInstance(this);


        //-- Zoom
        FrameLayout mContentView = (FrameLayout) getWindow().
        getDecorView().findViewById(android.R.id.content);
        final View zoom = mWebView.getZoomControls();
        mContentView.addView(zoom, ZOOM_PARAMS);
        zoom.setVisibility(View.GONE);
        //--

        final Activity activity = this;
        mWebView.setWebChromeClient(new WebChromeClient() {

           public void onProgressChanged(WebView view, int progress) {
               activity.setProgress(progress * 100);
           }

           public boolean onJsAlert(WebView view, String url,
                   String message, final android.webkit.JsResult result) {
               new AlertDialog.Builder(mWebView.getContext())
                       .setTitle("Concierge")
                       .setMessage(message)
                       .setPositiveButton(android.R.string.ok,
                               new AlertDialog.OnClickListener() {
                                   public void onClick(
                                           DialogInterface dialog,
                                           int which) {
                                       result.confirm();
                                   }
                               }).setCancelable(false).create().show();

               return true;
           };

           public boolean onJsConfirm(WebView view, String url,
                   String message, final android.webkit.JsResult result) {
               new AlertDialog.Builder(mWebView.getContext())
                       .setTitle("Concierge")
                       .setMessage(message)
                       .setPositiveButton(android.R.string.ok,
                               new AlertDialog.OnClickListener() {
                                   public void onClick(
                                           DialogInterface dialog,
                                           int which) {
                                       result.confirm();
                                   }
                               })
                       .setNegativeButton(android.R.string.cancel,
                               new AlertDialog.OnClickListener() {
                                   public void onClick(
                                           DialogInterface dialog,
                                           int which) {
                                       result.cancel();
                                   }
                               }).setCancelable(false).create().show();
               return true;
           }


        });
		mWebView.setWebViewClient(new WebViewClient() {
			@Override
			public boolean shouldOverrideUrlLoading(WebView view, String url) {
				view.loadUrl(url);
				return true;
			}

			@Override
			public void onReceivedError(WebView view, int errorCode,
					String description, String fallingUrl) {
				Toast.makeText(activity, "로딩오류" + description,
						Toast.LENGTH_SHORT).show();
			}

			// ページの読み込み完了
			@Override
			public void onPageFinished(WebView view, String url) {

				// String title = mWebView.getTitle();
				// Toast.makeText(mWebView.getContext(), title,
				// Toast.LENGTH_SHORT).show();

				// Log.d("title", title);
				// Toast.makeText(activity, title,
				// Toast.LENGTH_SHORT).show();
				//
				activity.setTitle(mWebView.getTitle());
			}
		});


    }


    /**
     * 再開
     * */
    public void onResume() {
    	super.onResume();
    	CookieSyncManager.getInstance().startSync();

	}

    /**
     * 一時停止
     * */
	public void onPause() {
		super.onPause();
		Log.d( "SkeletonActivity", "onPause" );
		CookieSyncManager.getInstance().stopSync();
		finish();//画面を隠す

	}

	protected void onDestroy() {
		super.onDestroy();

	}



	/**
	 * menu item thachi
	 * */
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        super.onOptionsItemSelected(item);
        switch(item.getItemId()){
        case R.id.reload :
            //何か処理
        	mWebView.reload();
            return true;

        case R.id.delete_histroy :
            //何か処理
        	mWebView.loadUrl(HOME);
        	mWebView.clearHistory();
            return true;
        }

        return false;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        super.onCreateOptionsMenu(menu);
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.hoge, menu);
        return true;
    }



    @Override
	public void onBackPressed() {
    	if (mWebView.canGoBack()) {
            mWebView.goBack();
            return;
        }else{
        	Toast.makeText(mWebView.getContext(), "最初の画面", Toast.LENGTH_LONG).show();
        }
	}


//	@Override
//    public boolean onKeyDown(int keyCode, KeyEvent event) {
//        if ((keyCode == KeyEvent.KEYCODE_BACK) && mWebView.canGoBack()) {
//            mWebView.goBack();
//            return true;
//        }
//        return super.onKeyDown(keyCode, event);
//
//    }






}