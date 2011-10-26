package com.s7soft.android.biscuit.calculator;

public enum Number {
	COMMA("."),

	ZERO("0"), DOUBLE_ZERO("0"),

	ONE("1"), TWO("2"), THREE("3"), FOUR("4"), FIVE("5"), SIX("6"), SEVEN("7"), EIGHT("8"), NINE("9"),

	;

	private String value;

	private Number(String n) {
		this.value = n;
	}

	public String getValue() {
		return this.value;
	}
}
