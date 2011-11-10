package com.s7soft.gae.itnews.blog;


import java.util.Hashtable;
import java.util.Vector;
import java.util.logging.Level;
import java.util.logging.Logger;

import org.apache.xmlrpc.client.XmlRpcClient;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;



public class BlogUtil {

	private static final Logger log = Logger.getLogger(BlogUtil.class.getName());



	@SuppressWarnings("unchecked")
	public static String newTistory(String title, String text, String teg, String category)
														throws Exception {
		log.log(Level.FINEST, "START newTistory [" + title + "]" );

		String tistoryNo = null;
		String categories[] =new String[]{category};

		XmlRpcClient server = new XmlRpcClient();
		XmlRpcClientConfigImpl config = new XmlRpcClientConfigImpl();
		Vector params = new Vector();

		config.setServerURL(new java.net.URL(Constants.SERVER_URL));
		params.addElement(new String(Constants.JPNEWS_BOLGID));
		params.addElement(new String(Constants.LoginID));
		params.addElement(new String(Constants.LoginPW));

		Hashtable hashtable = new Hashtable();
		hashtable.put("title", title);
		hashtable.put("description", text);
		hashtable.put("mt_keywords", teg);
		hashtable.put("categories", categories);
		params.addElement(hashtable);
		params.add(new Boolean(true));
		tistoryNo = server.execute(config, "metaWeblog.newPost",params).toString();
		log.log(Level.FINEST, "New Tistory :" +tistoryNo);

		log.log(Level.FINEST, "START newTistory [" + title + "]" );
		return tistoryNo;
	}




}
