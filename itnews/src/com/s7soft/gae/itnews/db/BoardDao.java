package com.s7soft.gae.itnews.db;

import java.util.List;

import javax.jdo.PersistenceManager;

import com.google.appengine.api.datastore.Key;
import com.google.appengine.api.datastore.KeyFactory;
import com.s7soft.gae.itnews.bean.Body;
import com.s7soft.gae.itnews.bean.Title;

public class BoardDao extends Dao{


	public static Long getMaxID(){
		PersistenceManager pm = PMF.getPersistenceManager();
		try {

			String query = "select from " + Title.class.getName()
			+ " order by key desc range 0,1";

			List<Title> greetings = (List<Title>) pm.newQuery(query).execute();

			if(greetings.size() > 0){
				return greetings.get(0).getKey();
			}


		} catch (Exception e) {
		} finally {
			pm.close();
		}
		return 0L;
	}

	public static Title get(Long key) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {

			Key k = KeyFactory.createKey(Title.class.getSimpleName(), key);
			Title e = pm.getObjectById(Title.class, k);
			return e;
		} catch (Exception e) {
		} finally {
			pm.close();
		}
		return null;
	}

	public static Long getLink(String link) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {

			String query = "select from " + Title.class.getName()
			+ " where url == '"+ link +"'";

			List<Title> greetings = (List<Title>) pm.newQuery(query).execute();

			if(greetings.size() > 0){
				return 1L;
			}


		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			pm.close();
		}
		return 0L;
	}


	public static List<Title> getList(int from, int to) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {
			if(from > 0){
				from = from - 1;
			}

			String query = "select from " + Title.class.getName()
					+ " order by insDate desc range " + from + "," + to;

			List<Title> greetings = (List<Title>) pm.newQuery(query).execute();
			greetings.size();

			return greetings;
		} catch (Exception e) {
		} finally {
			pm.close();
		}
		return null;

	}


	public static Body getBody(String key1 ,Long key2) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {

			Key k = KeyFactory.createKey(Body.class.getSimpleName(), key1+key2);
			Body e = pm.getObjectById(Body.class, k);
			return e;


//			String query = "select from " + Body.class.getName()
//						+ " where key == '"+key1+key2+"'"
//						+ " order by key range 0,1" ;
//
//			List<Body> greetings = (List<Body>) pm.newQuery(query).execute();
//			greetings.size();
//
//			if(greetings.size() > 0){
//				return greetings.get(0);
//			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			pm.close();
		}
		return null;
	}

	public static void add(Body body) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {
			pm.makePersistent(body);
		} finally {
			pm.close();
		}
	}

	public static void add(Title title) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {
			pm.makePersistent(title);
		} finally {
			pm.close();
		}
	}


}
