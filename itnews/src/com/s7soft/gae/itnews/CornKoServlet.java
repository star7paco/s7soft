package com.s7soft.gae.itnews;

import java.io.IOException;
import java.util.Date;
import java.util.List;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.appengine.api.datastore.Text;
import com.s7soft.gae.itnews.bean.Body;
import com.s7soft.gae.itnews.bean.Title;
import com.s7soft.gae.itnews.db.BoardDao;
import com.s7soft.gae.itnews.rss.RssReader;
import com.s7soft.gae.itnews.translation.TranslationUtil;
import com.sun.syndication.feed.synd.SyndContent;
import com.sun.syndication.feed.synd.SyndEntry;

public class CornKoServlet  extends HttpServlet {

	private static final long serialVersionUID = 1L;


	public void doGet(HttpServletRequest req, HttpServletResponse resp)
			throws IOException {
		resp.setContentType("text/plain");
		int i = 0;
		String rssUrl = "http://www.google.com/reader/public/atom/user%2F01437305406524732423%2Fbundle%2Fko";
		RssReader rss = new RssReader(rssUrl);

		List<SyndEntry> list = rss.getRss();


		try {

			for (SyndEntry rssEntry : list) {


				if(rssEntry.getTitle().startsWith("PR:")){continue;}

				log("title : "+rssEntry.getTitle());

				long id = BoardDao.getLink(rssEntry.getLink());

				if(id > 0){
					log("Stop is complet Item : "+rssEntry.getLink());
					break;
				}

				String link = rssEntry.getLink();
				String body = "";
				List<SyndContent> contents = (List<SyndContent>)rssEntry.getContents();
				for( SyndContent content : contents){
					body = body + content.getValue();
				}
				if(rssEntry.getDescription() != null ){
					body = body + rssEntry.getDescription().getValue();
				}


				while ( body.indexOf("<iframe") >= 0) {

					body = body.substring(0 , body.indexOf("<iframe")) + body.substring(body.indexOf("iframe>") + 7);

				}

				if( body.indexOf("<p style=\"padding:5px;background:#ddd;border:1px") > 0){
					body = body.substring(0, body.indexOf("<p style=\"padding:5px;background:#ddd;border:1px"));
				}

				if( body.indexOf("<img src=\"http://pixel.quantserve.com/pixel/") > 0){
					body = body.substring(0, body.indexOf("<img src=\"http://pixel.quantserve.com/pixel/"));
				}

				String kotitle = rssEntry.getTitle();
				String koBody = body;
				String jatitle = TranslationUtil.getChangeHtmlJaTOko(kotitle);
				String jabody = TranslationUtil.getChangeHtmlJaTOko(koBody);

				long maxid = BoardDao.getMaxID() + 1;

				Title title = new Title();
				title.setKey(maxid );
				title.setTitleJa(jatitle);
				title.setTitleKo(kotitle);
				title.setUrl(link);
				title.setInsDate(new Date());
				BoardDao.add(title);

				Body bodyJa = new Body();
				bodyJa.setKey( "ja"+ + maxid );
				bodyJa.setBody(new Text(jabody));
				BoardDao.add(bodyJa);



				Body bodyKo = new Body();
				bodyKo.setKey( "ko"+ maxid );
				bodyKo.setBody(new Text(koBody));
				BoardDao.add(bodyKo);

				i++;

			}

		} catch (Exception e) {
			e.printStackTrace();
		}
		resp.getWriter().println(i + " ok");
	}

}

