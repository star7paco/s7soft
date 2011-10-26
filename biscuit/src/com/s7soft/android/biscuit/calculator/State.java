package com.s7soft.android.biscuit.calculator;

public interface State {

	/**
	 * 数値ボタン
	 *
	 * @param context
	 * @param num
	 *            数値ボタン
	 */
	public abstract void onInputNumber(Context context, Number num);

	/**
	 * 四則演算ボタン
	 *
	 * @param context
	 * @param op
	 *            演算子
	 */
	public abstract void onInputOperation(Context context, Operation op);

	/**
	 * ＝ボタン
	 *
	 * @param context
	 */
	public abstract void onInputEquale(Context context);

	/**
	 * クリアボタン
	 *
	 * @param context
	 */
	public abstract void onInputClear(Context context);

	/**
	 * オールクリアボタン
	 *
	 * @param context
	 */
	public abstract void onInputAllClear(Context context);

}
