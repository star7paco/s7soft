package com.s7soft.gae.itnews.bean;

import java.util.Date;

import javax.jdo.annotations.IdGeneratorStrategy;
import javax.jdo.annotations.IdentityType;
import javax.jdo.annotations.PersistenceCapable;
import javax.jdo.annotations.Persistent;
import javax.jdo.annotations.PrimaryKey;

@PersistenceCapable (detachable = "true", identityType = IdentityType.APPLICATION)
public class Title {

	private static final long serialVersionUID = 1L;

	@PrimaryKey
    @Persistent(valueStrategy = IdGeneratorStrategy.IDENTITY)
    private Long key;

	@Persistent
	private String titleJa;

	@Persistent
	private String titleKo;

	@Persistent
	private String url;

	@Persistent
	private Date insDate;

	public long getKey() {
		return key;
	}

	public void setKey(long key) {
		this.key = key;
	}

	public String getTitleJa() {
		return titleJa;
	}

	public void setTitleJa(String titleJa) {
		this.titleJa = titleJa;
	}

	public String getTitleKo() {
		return titleKo;
	}

	public void setTitleKo(String titleKo) {
		this.titleKo = titleKo;
	}

	public String getUrl() {
		return url;
	}

	public void setUrl(String url) {
		this.url = url;
	}

	public Date getInsDate() {
		return insDate;
	}

	public void setInsDate(Date insDate) {
		this.insDate = insDate;
	}


	public String getTitle(String lang){
		if(lang.equals("ko")){
			return titleKo;
		}
		return titleJa;
	}

}
