package com.s7soft.android.biscuit.calculator;

import java.util.Stack;

public abstract class AbstractDisplay {
	// 数値の桁数
	protected final int DISPLAY_DIGIT = 12;
	// ディスプレイに表示される文字をスタックで保持
	protected final Stack<String> displayChar = new Stack<String>();
	// Trueの場合カンマ表示中（小数点入力モード）であることを表します
	protected boolean commaMode;
	// 小数点以下の桁数を保持します。
	protected int decimalPlaces;
	// マイナス記号です。
	protected boolean minus;

	// ディスプレイ表示を行います。
	public abstract void showDisplay(boolean format);

	// 押されたボタンにあわせて内部の値を遷移します
	public abstract void onInputNumber(Number num);

	// バックスペースが押されたときの処理です
	public abstract void onInputBackspace();

	// ディスプレイの内容をクリアします。
	public abstract void clear();

	// ディスプレイの内容をdouble型で取得します。
	public abstract double getNumber();

	// 引数の数字を文字列にしてディスプレイに設定します。
	public abstract void setNumber(double d);

	// エラーを表示します
	public abstract void setError();

	// エラー表示をクリアします
	public abstract void clearError();

	/**
	 * 引数がディスプレイの表示桁数を超えていないかチェックします.<br>
	 *
	 * @param d
	 *            チェックしたい値
	 * @return true：表示桁数を超える false：表示桁数に収まる
	 */
	public boolean isOverflow(double d) {

		StringBuffer sb = new StringBuffer();

		for (int i = 0; i < DISPLAY_DIGIT; i++) {
			sb.append("9");
		}
		double max = Double.parseDouble(sb.toString());
		if (d > max) {
			return true;
		}
		return false;
	}

	public String toString() {
		return displayChar.toString();
	}

}
