package com.s7soft.gae.itnews.db;

import java.util.List;

import javax.jdo.JDOHelper;
import javax.jdo.PersistenceManager;
import javax.jdo.PersistenceManagerFactory;

import com.google.appengine.api.datastore.Key;
import com.google.appengine.api.datastore.KeyFactory;
import com.google.appengine.api.datastore.Query;
import com.google.appengine.api.datastore.Query.FilterOperator;
import com.s7soft.gae.itnews.bean.Item;

public class ItemDao {
	private static final PersistenceManagerFactory PMF = JDOHelper
			.getPersistenceManagerFactory("transactions-optional");

	public static Item get(String key) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {

			Key k = KeyFactory.createKey(Item.class.getSimpleName(), key);
			Item e = pm.getObjectById(Item.class, k);
			return e;
		} catch (Exception e) {
		} finally {
			pm.close();
		}
		return null;
	}

	public static List<Item> getList(int from, int to) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {
			if(from > 0){
				from = from - 1;
			}

			String query = "select from " + Item.class.getName()
					+ " order by insDate desc range " + from + "," + to;
			pm.newQuery(query);

			List<Item> greetings = (List<Item>) pm.newQuery(query).execute();
			greetings.size();

			return greetings;
		} catch (Exception e) {
		} finally {
			pm.close();
		}
		return null;

	}

	public static List<Item> getListLimit5(Item lastItem) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {

			Query q = new Query(Item.class.getName());
			q.addFilter("", FilterOperator.LESS_THAN, lastItem.getInsDate());

			List<Item> greetings = (List<Item>) pm.newQuery(q).execute();
			greetings.size();
			return greetings;
		} catch (Exception e) {
		} finally {
			pm.close();
		}
		return null;

	}

	public static void add(Item item) {
		PersistenceManager pm = PMF.getPersistenceManager();
		try {
			pm.makePersistent(item);
		} finally {
			pm.close();
		}
	}

}
