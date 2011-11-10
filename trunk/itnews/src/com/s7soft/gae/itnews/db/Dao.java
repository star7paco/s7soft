package com.s7soft.gae.itnews.db;

import javax.jdo.JDOHelper;
import javax.jdo.PersistenceManagerFactory;

public class Dao {

	protected static final PersistenceManagerFactory PMF = JDOHelper
	.getPersistenceManagerFactory("transactions-optional");

}
