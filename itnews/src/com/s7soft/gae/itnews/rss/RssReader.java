package com.s7soft.gae.itnews.rss;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.List;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;

import com.sun.syndication.feed.synd.SyndEntry;
import com.sun.syndication.feed.synd.SyndFeed;
import com.sun.syndication.feed.synd.SyndImage;
import com.sun.syndication.io.SyndFeedInput;
import com.sun.syndication.io.XmlReader;
/**
 * Rss파일 파싱
 * @author gocc
 *
 */
public class RssReader {

	private static final Logger log = Logger.getLogger(RssReader.class.getName());


	public	URL feedUrl;
	public	List<SyndEntry> entries;
	public SyndImage image;
	public SyndFeed syndFeeds;

	public RssReader(String url){
//		Properties systemSettings = System.getProperties();
//		systemSettings.put("proxySet", "true");
//		systemSettings.put("http.proxyHost", "proxy.j-com.co.jp");
//		systemSettings.put("http.proxyPort", "8080");

		try {
			feedUrl = new URL(url);
		} catch (MalformedURLException e) {
			// TODO 自動生成された catch ブロック
			e.printStackTrace();
		}
		getRss();
	}

	public List<SyndEntry> getRss() {

		try {

			log.log(Level.FINEST, "START getRss [" + feedUrl + "]" );

			SyndFeedInput input = new SyndFeedInput();
			syndFeeds = input.build(new XmlReader(feedUrl));
			image = syndFeeds.getImage();
			entries = (List<SyndEntry>)syndFeeds.getEntries();

			log.log(Level.INFO, "entries.size = " + (entries != null ? entries.size() : "null") );

			return entries;

		} catch (Exception ex) {

			ex.printStackTrace();

			log.log(Level.WARNING, "getRss", ex);
			return null;
		}

	}

}
