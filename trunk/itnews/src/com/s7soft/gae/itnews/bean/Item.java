package com.s7soft.gae.itnews.bean;

import java.io.Serializable;
import java.util.Date;

import javax.jdo.annotations.IdGeneratorStrategy;
import javax.jdo.annotations.IdentityType;
import javax.jdo.annotations.PersistenceCapable;
import javax.jdo.annotations.Persistent;
import javax.jdo.annotations.PrimaryKey;

import com.google.appengine.api.datastore.Text;

@PersistenceCapable (detachable = "true", identityType = IdentityType.APPLICATION)
public class Item implements Serializable{

	private static final long serialVersionUID = 1L;

	@PrimaryKey
    @Persistent(valueStrategy = IdGeneratorStrategy.IDENTITY)
    private String key;

	@Persistent
	private String title;

	@Persistent
	private Text body;

	@Persistent
	private String memo;

	@Persistent
	private String url;

	@Persistent
	private String lang;

	@Persistent
	private Date insDate;

	@Persistent
	private Date blogOutDate;




	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getMemo() {
		return memo;
	}
	public void setMemo(String memo) {
		this.memo = memo;
	}
	public String getUrl() {
		return url;
	}
	public void setUrl(String url) {
		this.url = url;
	}
	public String getLang() {
		return lang;
	}
	public void setLang(String lang) {
		this.lang = lang;
	}
	public Date getInsDate() {
		return insDate;
	}
	public void setInsDate(Date insDate) {
		this.insDate = insDate;
	}
	public Date getBlogOutDate() {
		return blogOutDate;
	}
	public void setBlogOutDate(Date blogOutDate) {
		this.blogOutDate = blogOutDate;
	}
	public void setKey(String key) {
		this.key = key;
	}
	public String getKey() {
		return key;
	}
	public void setBody(Text body) {
		this.body = body;
	}
	public Text getBody() {
		return body;
	}


}
