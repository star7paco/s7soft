package com.s7soft.gae.itnews.bean;

import javax.jdo.annotations.IdGeneratorStrategy;
import javax.jdo.annotations.IdentityType;
import javax.jdo.annotations.PersistenceCapable;
import javax.jdo.annotations.Persistent;
import javax.jdo.annotations.PrimaryKey;

import com.google.appengine.api.datastore.Text;

@PersistenceCapable (detachable = "true", identityType = IdentityType.APPLICATION)
public class Body {

	private static final long serialVersionUID = 1L;

	@PrimaryKey
    @Persistent(valueStrategy = IdGeneratorStrategy.IDENTITY)
    private String key;


	@Persistent
	private String link;


	@Persistent
	private Text body;

	public Text getBody() {
		return body;
	}

	public void setBody(Text body) {
		this.body = body;
	}



	public void setLink(String link) {
		this.link = link;
	}

	public String getLink() {
		return link;
	}

	public void setKey(String key) {
		this.key = key;
	}

	public String getKey() {
		return key;
	}




}
