package com.s7soft.android.biscuit.calculator;

public interface Context {
	// 状態遷移
	public abstract void changeState(State state);

	// 演算実行し結果をディスプレイに表示します。
	public abstract double doOperation() throws CalcException;

	// ディスプレイ表示を更新します。
	void showDisplay();

	// ディスプレイ表示を引数の値で更新します。
	public abstract void showDisplay(double d);

	// ディスプレイ表示に数値を追加します。
	public abstract void addDisplayNumber(Number num);

	// ディスプレイ表示を変数Aへ保存します。
	public abstract void saveDisplayNumberToA();

	// ディスプレイ表示を変数Bへ保存します。
	public abstract void saveDisplayNumberToB();

	// 変数Aをクリアします。
	public abstract void clearA();

	// 変数Bをクリアします。
	public abstract void clearB();

	// 演算子を取得します。
	public abstract Operation getOp();

	// 演算子を設定します。
	public abstract void setOp(Operation op);

	// ディスプレイをクリアします。
	public abstract void clearDisplay();

	// メモリAからBへコピーします。
	public abstract void copyAtoB();

	// メモリAの取得です。
	public abstract double getA();

	// エラー表示を設定します。
	public abstract void setError();

	// エラー表示を解除します。
	public abstract void clearError();

	// ＋／－記号を反転します。
	public abstract void changeSign();
}
