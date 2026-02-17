# Dashboard Plan: Issue Entry / Supplier Ledger / Karigar Jama Voucher

## Overview

Extend the existing **Dashboard** (currently at `site/index`) to include summary widgets and recent activity for:

1. **Issue Entry** – Manual and voucher-linked DR/CR entries (feeds Ledger Report)
2. **Supplier Ledger** – Supplier transactions (each creates a DR Issue Entry)
3. **Karigar Jama Voucher** – Karigar jama vouchers (each creates a CR Issue Entry)

The current dashboard already shows Cash/Gold/Bank/Card/Discount/Item and recent cash entries. This plan adds a **Ledger section** so users see at a glance counts, totals, and recent records for Issue Entry, Supplier Ledger, and Karigar Jama.

---

## 1. Data to Show on Dashboard

### 1.1 Summary widgets (top row – same style as “Today Cash Amount” etc.)

| Widget | Data source | Display |
|--------|-------------|--------|
| **Issue Entry (today)** | `cp_issue_entry` where `issue_date = today` and `is_deleted = 0` | Count of entries + sum of amount (or separate DR/CR) |
| **Supplier Ledger (today)** | `cp_supplier_ledger_txn` where `txn_date = today` and `is_deleted = 0` | Count of txns + total amount |
| **Karigar Jama (today)** | `cp_karigar_jama_voucher` where `voucher_date = today` and `is_deleted = 0` | Count of vouchers + total amount |

Each widget can link to the respective module:
- Issue Entry → `issueEntry/index` or `issueEntry/admin`
- Supplier Ledger → `supplierLedger/index`
- Karigar Jama → `karigarJama/index`

### 1.2 Recent activity tables (below widgets)

| Block | Data | Columns (examples) |
|-------|------|--------------------|
| **Recent Issue Entries** | Last 10 from `cp_issue_entry` (e.g. `is_deleted=0`, order by `id DESC` or `issue_date DESC`) | Date, Account (customer name), DR/CR, Fine Wt, Amount, Remarks |
| **Recent Supplier Ledger** | Last 10 from `cp_supplier_ledger_txn` (e.g. `is_deleted=0`) | Date, Supplier, Voucher No, Total Fine Wt, Total Amount |
| **Recent Karigar Jama** | Last 10 from `cp_karigar_jama_voucher` (e.g. `is_deleted=0`) | Date, Karigar, Voucher No, Total Fine Wt, Total Amount |

Optional: “View all” link under each table to the admin/index of that module.

---

## 2. Implementation Steps

### 2.1 Backend (SiteController)

- In `SiteController::actionIndex()`:
  - **Issue Entry**: Query count and sum for today (e.g. by `issue_date`). Optionally split by DR/CR. Query last 10 issue entries with `customer` relation for name.
  - **Supplier Ledger**: Same for `SupplierLedgerTxn` (count/sum for today, last 10 with `supplier` relation).
  - **Karigar Jama**: Same for `KarigarJamaVoucher` (count/sum for today, last 10 with `karigar` relation).
- Pass these variables to the view (e.g. `$issueEntryStats`, `$recentIssueEntries`, `$supplierLedgerStats`, `$recentSupplierLedger`, `$karigarJamaStats`, `$recentKarigarJama`).

Example queries (concept only; adapt to your naming):

- Today’s issue entries:  
  `IssueEntry::model()->findAll('is_deleted=0 AND issue_date = :d', [':d' => date('Y-m-d')])`  
  Then compute count and sum(amount) in PHP or via `find()` with `select => 'COUNT(*), SUM(amount)'`.
- Recent 10:  
  `IssueEntry::model()->with('customer')->findAll(['condition' => 't.is_deleted=0', 'order' => 't.id DESC', 'limit' => 10])`.
- Same idea for `SupplierLedgerTxn` (txn_date, with supplier) and `KarigarJamaVoucher` (voucher_date, with karigar).

### 2.2 View (site/index.php)

- **New summary row**
  - Add three widgets (reuse existing “widget” / “widget-content-mini” structure from Today Cash/Gold/etc.):
    - Issue Entry (today): count + total amount; link to `issueEntry/index`.
    - Supplier Ledger (today): count + total amount; link to `supplierLedger/index`.
    - Karigar Jama (today): count + total amount; link to `karigarJama/index`.
- **New “Ledger” section**
  - One row with up to three blocks (or two blocks + one on next row if you prefer):
    - Block 1: “Recent Issue Entries” – table with date, account, DR/CR, fine wt, amount, remarks; link “View all” to `issueEntry/admin`.
    - Block 2: “Recent Supplier Ledger” – table with date, supplier, voucher no, total fine wt, total amount; “View all” to `supplierLedger/admin`.
    - Block 3: “Recent Karigar Jama” – table with date, karigar, voucher no, total fine wt, total amount; “View all” to `karigarJama/admin`.
- Reuse existing table classes (e.g. `table table-striped table-borderless table-vcenter`) and block layout (e.g. `block`, `block-title`) for consistency.

### 2.3 Optional enhancements

- **Date filter**: Add a simple date range or “Today / This week” toggle and pass it to the controller so widgets and “recent” lists can be filtered (e.g. “today” vs “last 7 days”).
- **Empty state**: If no records for today, show “0” and “No entries today”; in recent tables show “No result found” like existing cash tables.
- **Permissions**: Reuse existing access rules (dashboard is already for logged-in users); no extra permission needed unless you want to hide Ledger section for some roles.

---

## 3. File checklist

| Task | File |
|------|------|
| Add queries and pass data to view | `protected/controllers/SiteController.php` → `actionIndex()` |
| Add 3 summary widgets + 3 “recent” blocks | `protected/views/site/index.php` |
| (Optional) Add date filter | `SiteController.php` + `site/index.php` |

---

## 4. Suggested layout sketch

```
[ Page header: Home ]

[ Existing row: Today Cash | Today Gold | Today Bank | Today Card | Today Discount | Today Item ]

[ New row: Issue Entry (today) | Supplier Ledger (today) | Karigar Jama (today) ]

[ Existing row: Recent Cash Amount Entry | Recent Gold Amount Entry ]

[ New row: Recent Issue Entries | Recent Supplier Ledger | Recent Karigar Jama ]
```

You can reorder or move “Recent Issue / Supplier / Jama” above or below the existing Recent Cash/Gold blocks depending on what you want to emphasise.

---

## 5. Summary

- **Scope**: Add to current dashboard (site/index) summary widgets and recent-activity tables for Issue Entry, Supplier Ledger, and Karigar Jama Voucher.
- **Data**: Today’s count and total amount per module; last 10 records for each with key columns and links to full list.
- **Implementation**: Controller prepares stats and recent lists; view adds one row of three widgets and one row of three tables, reusing existing styles and links to existing modules.

If you want, the next step is to implement this in `SiteController` and `site/index.php` (with exact query and variable names matching your models).
